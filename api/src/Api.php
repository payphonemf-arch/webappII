<?php
declare(strict_types=1);
namespace Northwind;
use Northwind\Models\Entity;

final class Api
{
    private array $config;
    private ?\PDO $db = null;
    public function __construct() { $this->config = require __DIR__ . '/../config.php'; }
    private function db(): \PDO
    {
        return $this->db ??= Database::connection($this->config['db']);
    }
    private function respond(array $data,int $code=200): never
    { http_response_code($code); header('Content-Type: application/json; charset=utf-8'); echo json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES); exit; }
    private function body(): array
    { $v=json_decode(file_get_contents('php://input'),true); return is_array($v)?$v:$_POST; }
    private function token(array $claims): string
    {
        $enc=static fn($v)=>rtrim(strtr(base64_encode(json_encode($v)), '+/', '-_'),'=');
        $head=$enc(['typ'=>'JWT','alg'=>'HS256']); $payload=$enc($claims);
        return $head.'.'.$payload.'.'.rtrim(strtr(base64_encode(hash_hmac('sha256',$head.'.'.$payload,$this->config['jwt_secret'],true)), '+/', '-_'),'=');
    }
    private function auth(): array
    {
        $h=$_SERVER['HTTP_AUTHORIZATION']??'';
        if (!preg_match('/^Bearer\s+(.+)$/i',$h,$m)) $this->respond(['status'=>false,'error'=>'Authentication required'],401);
        $parts=explode('.',$m[1]);
        if(count($parts)!==3) $this->respond(['status'=>false,'error'=>'Invalid token'],401);
        $sig=rtrim(strtr(base64_encode(hash_hmac('sha256',$parts[0].'.'.$parts[1],$this->config['jwt_secret'],true)), '+/', '-_'),'=');
        $claims=json_decode(base64_decode(strtr($parts[1],'-_','+/')),true);
        if(!hash_equals($sig,$parts[2])||!is_array($claims)||($claims['exp']??0)<time()) $this->respond(['status'=>false,'error'=>'Invalid or expired token'],401);
        return $claims;
    }
    public function run(): void
    {
        header('Access-Control-Allow-Headers: Content-Type, Authorization'); header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        if(($_SERVER['REQUEST_METHOD']??'GET')==='OPTIONS'){http_response_code(204);return;}
        $path=parse_url($_SERVER['REQUEST_URI']??'/',PHP_URL_PATH)?:'/';
        if($path==='/'||$path==='/index.php'){require dirname(__DIR__,2).'/public/index.html';return;}
        if(!str_starts_with($path,'/api/v1/')){$this->respond(['status'=>false,'error'=>'Not found'],404);}
        try {
            $method=$_SERVER['REQUEST_METHOD']??'GET'; $route=trim(substr($path,8),'/'); $body=$this->body();
            if($route==='auth/login'&&$method==='POST'){
                $s=$this->db()->prepare('SELECT i_usr_id,i_usr_uname,i_usr_pwd FROM tb_users WHERE i_usr_uname = :u LIMIT 1');$s->execute(['u'=>$body['username']??'']);$u=$s->fetch();
                $password=(string)($body['password']??'');
                $stored=(string)($u['i_usr_pwd']??'');
                $valid=$u&&((str_starts_with($stored,'$2y$')||str_starts_with($stored,'$argon2'))?password_verify($password,$stored):hash_equals($stored,$password));
                if(!$valid)$this->respond(['status'=>false,'error'=>'Invalid username or password'],401);
                $now=time();$token=$this->token(['sub'=>(int)$u['i_usr_id'],'name'=>$u['i_usr_uname'],'iat'=>$now,'exp'=>$now+$this->config['token_ttl']]);
                $this->respond(['status'=>true,'data'=>['token'=>$token,'user'=>['id'=>(int)$u['i_usr_id'],'username'=>$u['i_usr_uname']]]]);
            }
            if($route==='auth/me'&&$method==='GET'){$claims=$this->auth();$this->respond(['status'=>true,'data'=>['id'=>$claims['sub'],'username'=>$claims['name']]]);}
            $claims=$this->auth();
            if($route==='dashboard'&&$method==='GET'){$this->dashboard();}
            if($route==='reports'&&$method==='GET'){$this->reports();}
            if(preg_match('~^orders(?:/(\d+))?$~',$route,$m)){$this->orders($method,$m[1]??null,$body);}
            if(preg_match('~^([^/]+)(?:/(\d+))?$~',$route,$m)&&isset(Entity::MAP[$m[1]])){$this->crud($m[1],$method,$m[2]??null,$body);}
            $this->respond(['status'=>false,'error'=>'Not found'],404);
        } catch(\PDOException $e){$this->respond(['status'=>false,'error'=>'Database request failed. Check connection settings and imported schema.'],500);}
          catch(\Throwable $e){$this->respond(['status'=>false,'error'=>'Request failed'],500);}
    }
    private function crud(string $key,string $method,?string $id,array $body): void
    {
        $entity=Entity::MAP[$key];$table=$entity['table'];$pk=$entity['pk'];$fields=$entity['fields'];$db=$this->db();
        $from=$key==='products'?'tb_products p LEFT JOIN tb_categories c ON c.i_CategoryID=p.i_CategoryID LEFT JOIN tb_suppliers s ON s.i_SupplierID=p.i_SupplierID':$table;
        $pkExpr=$key==='products'?'p.i_ProductID':$pk;
        if($method==='GET'){
            $where='';$bind=[];
            if($id){$where=" WHERE $pkExpr=:id";$bind['id']=(int)$id;}
            elseif($key==='products'){
                $clauses=[];
                if(isset($_GET['search'])&&$_GET['search']!==''){$clauses[]='p.c_ProductName LIKE :q';$bind['q']='%'.$_GET['search'].'%';}
                if(isset($_GET['category_id'])&&$_GET['category_id']!==''){$clauses[]='p.i_CategoryID=:category';$bind['category']=(int)$_GET['category_id'];}
                if($clauses)$where=' WHERE '.implode(' AND ',$clauses);
            }
            if(!$id){$page=max(1,(int)($_GET['page']??1));$limit=min(100,max(1,(int)($_GET['limit']??25)));$offset=($page-1)*$limit;
                $s=$db->prepare("SELECT COUNT(*) FROM $from$where");$s->execute($bind);$total=(int)$s->fetchColumn();
                $select=$key==='products'?'SELECT p.*,c.c_CategoryName AS category_name,s.c_SupplierName AS supplier_name':'SELECT *';
                $s=$db->prepare("$select FROM $from$where ORDER BY $pkExpr DESC LIMIT :limit OFFSET :offset");foreach($bind as $name=>$value)$s->bindValue(':'.$name,$value,is_int($value)?\PDO::PARAM_INT:\PDO::PARAM_STR);$s->bindValue(':limit',$limit,\PDO::PARAM_INT);$s->bindValue(':offset',$offset,\PDO::PARAM_INT);$s->execute();$rows=$s->fetchAll();
                $this->respond(['status'=>true,'data'=>array_map(fn($r)=>Entity::present($r,$key),$rows),'total'=>$total,'page'=>$page,'limit'=>$limit]);
            }
            $select=$key==='products'?'SELECT p.*,c.c_CategoryName AS category_name,s.c_SupplierName AS supplier_name':'SELECT *';
            $s=$db->prepare("$select FROM $from$where");$s->execute($bind);$row=$s->fetch();$this->respond(['status'=>true,'data'=>$row?Entity::present($row,$key):null],$row?200:404);
        }
        if($method==='DELETE'&&$id){$s=$db->prepare("DELETE FROM $table WHERE $pk=:id");$s->execute(['id'=>(int)$id]);$this->respond(['status'=>true,'message'=>'Deleted']);}
        if(($method==='POST'||$method==='PUT')&&($id||$method==='POST')){
            $values=[];foreach($fields as $api=>$col)if(array_key_exists($api,$body))$values[$col]=$body[$api];
            if(!$values)$this->respond(['status'=>false,'error'=>'No fields supplied'],422);
            if($method==='POST'){
                if($entity['auto']) { /* MySQL assigns this primary key. */ }
                else { $values[$pk]=(int)$db->query("SELECT COALESCE(MAX($pk),0)+1 FROM $table")->fetchColumn(); }
                $columns=array_keys($values);$marks=array_map(fn($c)=>':'.$c,$columns);
                $s=$db->prepare('INSERT INTO '.$table.' ('.implode(',',$columns).') VALUES ('.implode(',',$marks).')');$s->execute($values);$newId=(int)$db->lastInsertId();
                if(!$newId){$q=$db->query("SELECT MAX($pk) FROM $table");$newId=(int)$q->fetchColumn();}
                $this->respond(['status'=>true,'data'=>['id'=>$newId]],201);
            }
            $sets=[];foreach($values as $col=>$v)$sets[]="$col=:$col";$values['__id']=(int)$id;
            $s=$db->prepare("UPDATE $table SET ".implode(',',$sets)." WHERE $pk=:__id");$s->execute($values);$this->respond(['status'=>true,'message'=>'Updated']);
        }
        $this->respond(['status'=>false,'error'=>'Method not allowed'],405);
    }
    private function orders(string $method,?string $id,array $body): void
    {
        $db=$this->db();
        if($method==='GET'){
            if($id){$s=$db->prepare('SELECT o.*,c.c_customername,e.c_FirstName,e.c_LastName,s.c_ShipperName FROM tb_orders o LEFT JOIN tb_customers c ON c.i_customerid=o.i_CustomerID LEFT JOIN tb_employees e ON e.i_EmployeeID=o.i_EmployeeID LEFT JOIN tb_shippers s ON s.i_ShipperID=o.i_ShipperID WHERE o.i_OrderID=:id');$s->execute(['id'=>(int)$id]);$order=$s->fetch();if(!$order)$this->respond(['status'=>false,'error'=>'Order not found'],404);$q=$db->prepare('SELECT d.i_ProductID AS product_id,p.c_ProductName AS product,d.i_Quantity AS quantity,p.i_Price AS price FROM tb_orderdetails d LEFT JOIN tb_products p ON p.i_ProductID=d.i_ProductID WHERE d.i_OrderID=:id');$q->execute(['id'=>(int)$id]);$order['items']=$q->fetchAll();$this->respond(['status'=>true,'data'=>$order]);}
            $limit=min(100,max(1,(int)($_GET['limit']??25)));$offset=max(0,((int)($_GET['page']??1)-1)*$limit);$s=$db->prepare('SELECT o.i_OrderID AS id,o.c_OrderDate AS order_date,c.c_customername AS customer,e.c_FirstName AS first_name,e.c_LastName AS last_name,s.c_ShipperName AS shipper,COALESCE(t.item_count,0) AS item_count,COALESCE(t.estimated_total,0) AS estimated_total FROM tb_orders o LEFT JOIN tb_customers c ON c.i_customerid=o.i_CustomerID LEFT JOIN tb_employees e ON e.i_EmployeeID=o.i_EmployeeID LEFT JOIN tb_shippers s ON s.i_ShipperID=o.i_ShipperID LEFT JOIN (SELECT d.i_OrderID,COUNT(*) AS item_count,SUM(d.i_Quantity*p.i_Price) AS estimated_total FROM tb_orderdetails d JOIN tb_products p ON p.i_ProductID=d.i_ProductID GROUP BY d.i_OrderID) t ON t.i_OrderID=o.i_OrderID ORDER BY o.i_OrderID DESC LIMIT :limit OFFSET :offset');$s->bindValue(':limit',$limit,\PDO::PARAM_INT);$s->bindValue(':offset',$offset,\PDO::PARAM_INT);$s->execute();$this->respond(['status'=>true,'data'=>$s->fetchAll(),'total'=>(int)$db->query('SELECT COUNT(*) FROM tb_orders')->fetchColumn()]);
        }
        if($method==='POST'){$db->beginTransaction();$orderId=(int)$db->query('SELECT COALESCE(MAX(i_OrderID),0)+1 FROM tb_orders')->fetchColumn();$s=$db->prepare('INSERT INTO tb_orders(i_OrderID,i_CustomerID,i_EmployeeID,c_OrderDate,i_ShipperID) VALUES(:id,:customer,:employee,:date,:shipper)');$s->execute(['id'=>$orderId,'customer'=>(int)($body['customer_id']??0),'employee'=>(int)($body['employee_id']??0),'date'=>$body['order_date']??date('j/n/Y'),'shipper'=>(int)($body['shipper_id']??0)]);if(isset($body['product_id'],$body['quantity'])){$detailId=(int)$db->query('SELECT COALESCE(MAX(i_OrderDetailID),0)+1 FROM tb_orderdetails')->fetchColumn();$line=$db->prepare('INSERT INTO tb_orderdetails(i_OrderDetailID,i_OrderID,i_ProductID,i_Quantity) VALUES(:detail,:order,:product,:quantity)');$line->execute(['detail'=>$detailId,'order'=>$orderId,'product'=>(int)$body['product_id'],'quantity'=>max(1,(int)$body['quantity'])]);}$db->commit();$this->respond(['status'=>true,'data'=>['id'=>$orderId]],201);}
        if($method==='DELETE'&&$id){$db->beginTransaction();$s=$db->prepare('DELETE FROM tb_orderdetails WHERE i_OrderID=:id');$s->execute(['id'=>(int)$id]);$s=$db->prepare('DELETE FROM tb_orders WHERE i_OrderID=:id');$s->execute(['id'=>(int)$id]);$db->commit();$this->respond(['status'=>true,'message'=>'Deleted']);}
        $this->respond(['status'=>false,'error'=>'Method not allowed'],405);
    }
    private function dashboard(): never
    {
        $db=$this->db();$data=[];foreach(['products'=>'tb_products','customers'=>'tb_customers','orders'=>'tb_orders','suppliers'=>'tb_suppliers'] as $k=>$t)$data[$k]=(int)$db->query("SELECT COUNT(*) FROM $t")->fetchColumn();
        $data['estimated_sales']=(float)$db->query('SELECT COALESCE(SUM(d.i_Quantity*p.i_Price),0) FROM tb_orderdetails d JOIN tb_products p ON p.i_ProductID=d.i_ProductID')->fetchColumn();$data['recent_orders']=$db->query('SELECT o.i_OrderID AS id,o.c_OrderDate AS date,c.c_customername AS customer,COALESCE(t.item_count,0) AS item_count,COALESCE(t.estimated_total,0) AS estimated_total FROM tb_orders o LEFT JOIN tb_customers c ON c.i_customerid=o.i_CustomerID LEFT JOIN (SELECT d.i_OrderID,COUNT(*) AS item_count,SUM(d.i_Quantity*p.i_Price) AS estimated_total FROM tb_orderdetails d JOIN tb_products p ON p.i_ProductID=d.i_ProductID GROUP BY d.i_OrderID) t ON t.i_OrderID=o.i_OrderID ORDER BY o.i_OrderID DESC LIMIT 6')->fetchAll();
        $data['top_products']=$db->query('SELECT p.c_ProductName AS name,SUM(d.i_Quantity) AS quantity FROM tb_orderdetails d JOIN tb_products p ON p.i_ProductID=d.i_ProductID GROUP BY p.i_ProductID,p.c_ProductName ORDER BY quantity DESC LIMIT 5')->fetchAll();$this->respond(['status'=>true,'data'=>$data]);
    }
    private function reports(): never
    {
        $db=$this->db();
        $sales=$db->query('SELECT c_OrderDate AS label,COUNT(*) AS orders FROM tb_orders GROUP BY c_OrderDate ORDER BY c_OrderDate LIMIT 12')->fetchAll();
        $popular=$db->query('SELECT p.i_ProductID AS product_id,p.c_ProductName AS product,cat.c_CategoryName AS category,s.c_SupplierName AS supplier,p.c_Unit AS unit,SUM(d.i_Quantity) AS quantity,MAX(p.i_Price) AS current_unit_price,SUM(d.i_Quantity*p.i_Price) AS estimated_sales FROM tb_orderdetails d JOIN tb_products p ON p.i_ProductID=d.i_ProductID LEFT JOIN tb_categories cat ON cat.i_CategoryID=p.i_CategoryID LEFT JOIN tb_suppliers s ON s.i_SupplierID=p.i_SupplierID GROUP BY p.i_ProductID,p.c_ProductName,cat.c_CategoryName,s.c_SupplierName,p.c_Unit ORDER BY quantity DESC LIMIT 10')->fetchAll();
        $lines=$db->query('SELECT o.i_OrderID AS order_id,o.c_OrderDate AS order_date,c.c_customername AS customer,c.c_country AS country,e.c_FirstName AS employee_first_name,e.c_LastName AS employee_last_name,s.c_ShipperName AS shipper,p.i_ProductID AS product_id,p.c_ProductName AS product,cat.c_CategoryName AS category,d.i_Quantity AS quantity,p.i_Price AS current_unit_price,(d.i_Quantity*p.i_Price) AS estimated_line_total FROM tb_orderdetails d JOIN tb_orders o ON o.i_OrderID=d.i_OrderID LEFT JOIN tb_customers c ON c.i_customerid=o.i_CustomerID LEFT JOIN tb_employees e ON e.i_EmployeeID=o.i_EmployeeID LEFT JOIN tb_shippers s ON s.i_ShipperID=o.i_ShipperID JOIN tb_products p ON p.i_ProductID=d.i_ProductID LEFT JOIN tb_categories cat ON cat.i_CategoryID=p.i_CategoryID ORDER BY o.i_OrderID DESC,d.i_OrderDetailID')->fetchAll();
        $this->respond(['status'=>true,'data'=>['orders_by_date'=>$sales,'popular_products'=>$popular,'order_lines'=>$lines,'estimated_sales'=>array_sum(array_map(fn($line)=>(float)$line['estimated_line_total'],$lines))]]);
    }
}
