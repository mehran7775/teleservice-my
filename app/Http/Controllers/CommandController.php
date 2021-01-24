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
    }
}
