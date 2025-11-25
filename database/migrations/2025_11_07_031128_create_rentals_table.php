    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('rentals', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->date('rental_date');
                $table->date('return_date');
                // $table->timestamp('returned_at')->nullable();
                $table->decimal('total_price',12,2)->default(0);
                $table->string('payment_method')->nullable();
                $table->enum('status',['pending','rented','returned','canceled'])->default('pending');
                $table->softDeletes();
                $table->timestamps();

            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('rentals');
        }
    };
