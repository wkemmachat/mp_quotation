Change git url 

git remote -v 
git remote set-url origin https://github.com/wkemmachat/mp_quotation.git
change



php artisan make:model Role -mcr
php artisan make:migration create_role_user_table --create=role_user


#reset git 

git fetch origin

git reset --hard origin/master

git pull


#git push
git push origin master 



#Edit after clone and commit 

#Make Controller
php artisan make:controller ProductController

#Make Model
php artisan make:model Product

#Make Model migrade (-m) conroller (-c) 
php artisan make:model Todo -mcr

#Run Migration by name
php artisan migrate --path=/database/migrations/my_migration.php
php artisan make:model TransferInOut -mcr

#tinker
php artisan tinker
App\Product::find(1)->stock_real_time;

#Multiple Sub cat 
https://www.5balloons.info/hierarchical-data-laravel-relationship-display/

#tinker
ProductCategory::where('parent_id',NULL)->get();

$cat = App\ProductCategory::find(22);
$cat = App\ProductCategory::find(22)->has_parent;
