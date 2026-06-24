<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  if (DB::getDriverName()==='mysql') DB::statement("ALTER TABLE users MODIFY role ENUM('admin','petugas','user') NOT NULL DEFAULT 'user'");
  Schema::table('bookings', function(Blueprint $t){
   $t->foreignId('user_id')->nullable()->after('guest_id')->constrained('users')->nullOnDelete();
   $t->enum('booking_source',['walk_in','online'])->default('walk_in')->after('created_by');
  });
 }
 public function down(): void {
  Schema::table('bookings', function(Blueprint $t){$t->dropConstrainedForeignId('user_id');$t->dropColumn('booking_source');});
 }
};
