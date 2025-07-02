<?php

namespace App\Models;

use CodeIgniter\Model;

class DiskonModel extends Model
{
    protected $table = 'diskon';

    protected $primaryKey = 'id';

    /**
     * Kolom mana saja yang diizinkan untuk diisi atau diubah
     * melalui metode save(), insert(), atau update().
     * Ini penting untuk keamanan (Mass Assignment).
     */
    protected $allowedFields = ['tanggal', 'nominal'];

    /**
     * Mengaktifkan fitur auto-timestamps.
     * CodeIgniter akan secara otomatis mengisi kolom 'created_at' dan 'updated_at'.
     */
    protected $useTimestamps = true;
}