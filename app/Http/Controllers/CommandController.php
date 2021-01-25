<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Artisan;

class CommandController extends Controller
{
    public function index($name){
        if ($name == 'cache-clear') {
            try {
             echo 'php artisan cache:clear... <br>';
             Artisan::call('cache:clear');
             echo 'app cache clear completed';
            }
            catch (Exception $e) {
             return $e->getMessage();
            }
           }
		if ($name == 'route-clear') {
            try {
             echo 'php artisan route:clear... <br>';
             Artisan::call('route:clear');
             echo 'app cache route completed';
            }
            catch (Exception $e) {
             return $e->getMessage();
            }
           }
         elseif ($name == 'view-clear') {
           try {
             echo 'php artisan view:clear... <br>';
             Artisan::call('view:clear');
             echo 'app view clear completed';
           }
           catch (Exception $e) {
             return $e->getMessage();
           }
     
         }
         elseif ($name == 'config-clear') {
           try {
             echo 'php artisan config:clear... <br>';
             Artisan::call('config:clear');
             echo 'app config clear completed';
           }
           catch (Exception $e) {
             return $e->getMessage();
           }
     
         }
		  elseif ($name == 'config-cache') {
           try {
             echo 'php artisan config:cache... <br>';
             Artisan::call('config:cache');
             echo 'app config cache completed';
           }
           catch (Exception $e) {
             return $e->getMessage();
           }
     
         }
         elseif ($name == 'migrate') {
           try {
             echo 'php artisan migrate... <br>';
             Artisan::call('migrate');
             echo 'app migrate completed';
           }
           catch (Exception $e) {
             return $e->getMessage();
           }
     
         }
         elseif ($name == 'migrate-refresh') {
           try {
             echo 'php artisan migrate:refresh... <br>';
             Artisan::call('migrate:refresh');
             echo 'app migrate:refresh completed';
           }
           catch (Exception $e) {
             return $e->getMessage();
           }
     
         }
         elseif ($name == 'migrate-fresh') {
           try {
             echo 'php artisan migrate:fresh... <br>';
             Artisan::call('migrate:fresh');
             echo 'app migrate:fresh completed';
           }
           catch (Exception $e) {
             return $e->getMessage();
           }
     
         }
         elseif ($name == 'migrate-rollback') {
           try {
             echo 'php artisan migrate:rollback... <br>';
             Artisan::call('migrate:rollback');
             echo 'app migrate:rollback completed';
           }
           catch (Exception $e) {
             return $e->getMessage();
           }
     
         }
         elseif($name=='passport-install'){
            try {
           echo 'php artisan passport:install... <br>';
           Artisan::call('passport:install');
           echo 'app passport:install completed';
          }
          catch (Exception $e) {
           return $e->getMessage();
          }
       }
		  elseif($name=='storage-link'){
            try {
           echo 'php artisan storage:link... <br>';
           Artisan::call('storage:link');
           echo 'app storage:link completed';
          }
          catch (Exception $e) {
           return $e->getMessage();
          }
       }
    }
}
