<?php
declare(strict_types=1);
namespace Northwind\Models;

/** Whitelisted mapping between public API fields and legacy Northwind columns. */
final class Entity
{
    public const MAP = [
        'products'=>['table'=>'tb_products','pk'=>'i_ProductID','auto'=>true,'fields'=>['name'=>'c_ProductName','supplier_id'=>'i_SupplierID','category_id'=>'i_CategoryID','unit'=>'c_Unit','price'=>'i_Price']],
        'categories'=>['table'=>'tb_categories','pk'=>'i_CategoryID','auto'=>false,'fields'=>['name'=>'c_CategoryName','description'=>'c_Description']],
        'customers'=>['table'=>'tb_customers','pk'=>'i_customerid','auto'=>false,'fields'=>['name'=>'c_customername','contact'=>'c_contactname','address'=>'c_address','city'=>'c_city','postal_code'=>'c_postalcode','country'=>'c_country']],
        'suppliers'=>['table'=>'tb_suppliers','pk'=>'i_SupplierID','auto'=>false,'fields'=>['name'=>'c_SupplierName','contact'=>'c_ContactName','address'=>'c_Address','city'=>'c_City','postal_code'=>'c_PostalCode','country'=>'c_Country','phone'=>'c_Phone']],
        'employees'=>['table'=>'tb_employees','pk'=>'i_EmployeeID','auto'=>false,'fields'=>['last_name'=>'c_LastName','first_name'=>'c_FirstName','birth_date'=>'c_BirthDate','photo'=>'c_Photo','notes'=>'c_Notes']],
        'shippers'=>['table'=>'tb_shippers','pk'=>'i_ShipperID','auto'=>false,'fields'=>['name'=>'c_ShipperName','phone'=>'c_Phone']],
    ];

    public static function present(array $row,string $key): array
    {
        $config=self::MAP[$key];$out=['id'=>(int)$row[$config['pk']]];
        foreach($config['fields'] as $api=>$column)$out[$api]=$row[$column]??null;
        if($key==='products'){$out['category_name']=$row['category_name']??null;$out['supplier_name']=$row['supplier_name']??null;}
        return $out;
    }
}
