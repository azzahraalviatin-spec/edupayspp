    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('tagihans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
                $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajarans')->onDelete('cascade');
                $table->tinyInteger('bulan'); // 1-12
                $table->decimal('nominal_awal', 10, 2);
                $table->decimal('total_potongan', 10, 2)->default(0);
                $table->decimal('nominal_bayar', 10, 2);
                $table->enum('status', ['belum_bayar', 'menunggu', 'lunas'])->default('belum_bayar');
                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('tagihans');
        }
    };