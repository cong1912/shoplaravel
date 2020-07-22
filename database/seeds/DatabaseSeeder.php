<?php

use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
      // Call the php artisan migrate:refresh
      $this->command->call('migrate:refresh');
      $this->command->warn("Data cleared, starting from blank database.");
      factory("App\User")->create(["email" => "admin@admin.com"]);
      $this->command->info('Default Email added.');
    }

    if ($this->command->confirm('Do you wish to auto generate data sample ?')) {
      $user =  mt_rand(3,9);
      factory("App\User", $user)->create();
      $this->command->info('User '. $user .' added.');

      factory("App\Models\Brand", 12)->create();
      $this->command->info('Brand 12 added.');

      factory("App\Models\Category", 24)->create();
      $this->command->info('Category 24 added.');

      factory("App\Models\Attribute", 24)->create();
      $this->command->info('Attribute 24 added.');

      factory("App\Models\Product", 50)->create()->each(function ($row) {
        $row->categories()->attach(mt_rand(1,24));
        $arrayIds = [];

        $atrribute = mt_rand(1,5);
        $productAttributes = factory("App\Models\ProductAttribute", $atrribute)->create(["product_id" => $row->id]);

        foreach ($productAttributes as $item) {
          $arrayIds = array_merge($arrayIds, $item->attributes_ids);
        }
        $row->attributes()->attach(array_unique($arrayIds));
      });
      $this->command->info('Product 50 added.');

      factory("App\Models\Slide", 4)->create();
      $this->command->info('Slide 4 added.');

      factory("App\Models\Page", 4)->create()->each(function ($row) {
        factory("App\Models\Menu")->create(["page_slug" => $row->slug]);
      });
      $this->command->info('Page 4 added.');
    }

  }
}
