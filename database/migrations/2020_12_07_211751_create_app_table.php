<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        // company table
//        Schema::create('company_table', function (Blueprint $table) {
//            $table->id();
//            $table->string('company_name');
//            $table->string('company_fax');
//            $table->string('company_website');
//            $table->string('company_picture');
//            $table->string('company_logo');
//            $table->text('company_bio');
//        });
//        // branch table
//        Schema::create('branch_table', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('company_id');
//            $table->string('branch_name');
//            $table->string('branch_location');
//            $table->string('branch_timings_days');
//            $table->string('branch_timings_times');
//            $table->string('branch_picture');
//            $table->text('branch_description');
//            $table->foreign('company_id')->references('id')->on('company_table')->onDelete('cascade');
//        });
//        // branch table
//        Schema::create('user_table', function (Blueprint $table) {
//            $table->id();
//            $table->string('user_name');
//            $table->string('user_email')->unique();
//            $table->string('user_mobile')->unique();
//            $table->string('user_telephone')->unique();
//            $table->string('user_date_of_birth');
//            $table->enum('user_gender',['male','female']);
//            $table->string('user_cpr');
//            $table->string('user_password');
//            $table->string('user_city');
//            $table->string('user_road');
//            $table->string('user_building');
//            $table->string('user_flat');
//        });
//        // insurance table
//        Schema::create('insurance_table', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('user_id');
//            $table->unsignedBigInteger('company_id');
//            $table->enum('policy_type',['3rd_party','full_coverage'])->default('full_coverage');
//            $table->enum('package_type',['normal','silver','gold'])->default('normal');
//            $table->timestamp('join_date')->default(now());
//            $table->timestamp('expire_date')->default(now());
//            $table->float('total_price');
//            $table->enum('status',['pending','completed'])->default('pending');
//            $table->enum('type',['car','fire','travel','health']);
//            $table->foreign('user_id')->references('id')->on('user_table')->onDelete('cascade');
//            $table->foreign('company_id')->references('id')->on('company_table')->onDelete('cascade');
//
//
//        });
//        // car insurance table
//        Schema::create('car_policy_table', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('insurance_id');
//            $table->string('car_reg_num');
//            $table->enum('car_type',['jeep','van','sport']);
//            $table->year('car_model_year');
//            $table->string('car_model');
//            $table->string('car_cc');
//            $table->string('car_seating');
//            $table->string('car_value');
//            $table->enum('car_status',['used','new']);
//            $table->foreign('insurance_id')->references('id')->on('insurance_table')->onDelete('cascade');
//        });
//        // fire insurance table
//        Schema::create('fire_policy_table', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('insurance_id');
//            $table->string('building_area');
//            $table->enum('building_type',['villa','multistory','office','warehouse']);
//            $table->foreign('insurance_id')->references('id')->on('insurance_table')->onDelete('cascade');
//        });
//        // health insurance table
//        Schema::create('health_policy_table', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('insurance_id');
//            $table->string('dental');
//            $table->string('maternity');
//            $table->string('insured_name');
//            $table->string('insured_cpr');
//            $table->foreign('insurance_id')->references('id')->on('insurance_table')->onDelete('cascade');
//        });
//        // travel insurance table
//        Schema::create('travel_policy_table', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('insurance_id');
//            $table->string('destination');
//            $table->string('traveller_name');
//            $table->string('traveller_passport');
//            $table->foreign('insurance_id')->references('id')->on('insurance_table')->onDelete('cascade');
//        });
//        // cat claim table
//        Schema::create('car_claim_table', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('insurance_id');
//            $table->timestamp('accident_date_time');
//            $table->string('accident_location');
//            $table->string('accident_traffic_report_photo');
//            $table->string('accident_car_report_photo');
//            $table->enum('claim_status',['pending','completed']);
//            $table->foreign('insurance_id')->references('id')->on('insurance_table')->onDelete('cascade');
//        });
//        // fire table
//        Schema::create('fire_claim_table', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('insurance_id');
//            $table->timestamp('fire_claim_date_time');
//            $table->text('fire_claim_summary');
//            $table->enum('claim_status',['pending','completed']);
//            $table->foreign('insurance_id')->references('id')->on('insurance_table')->onDelete('cascade');
//        });
//        // health table
//        Schema::create('health_claim_table', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('insurance_id');
//            $table->string('hospital_invoice_photo');
//            $table->string('pharmacy_invoice_photo');
//            $table->timestamp('health_claim_date_time');
//            $table->enum('claim_status',['pending','completed']);
//            $table->foreign('insurance_id')->references('id')->on('insurance_table')->onDelete('cascade');
//        });
//        // travel table
//        Schema::create('travel_claim_table', function (Blueprint $table) {
//            $table->id();
//            $table->unsignedBigInteger('insurance_id');
//            $table->timestamp('travel_claim_date_time');
//            $table->text('travel_claim_summary');
//            $table->enum('claim_status',['pending','completed']);
//            $table->foreign('insurance_id')->references('id')->on('insurance_table')->onDelete('cascade');
//        });
//        Schema::dropIfExists('company_table');
//        Schema::dropIfExists('branch_table');
//        Schema::dropIfExists('user_table');
//        Schema::dropIfExists('insurance_table');
//        Schema::dropIfExists('car_policy_table');
//        Schema::dropIfExists('fire_policy_table');
//        Schema::dropIfExists('health_policy_table');
//        Schema::dropIfExists('travel_policy_table');
//        Schema::dropIfExists('car_claim_table');
//        Schema::dropIfExists('fire_claim_table');
//        Schema::dropIfExists('health_claim_table');
//        Schema::dropIfExists('travel_claim_table');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
