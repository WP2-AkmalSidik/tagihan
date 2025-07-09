<?php

namespace App\Interfaces;

interface PenggajianInterface
{
    public function hitungGaji($karyawanId, $periode, $jumlahHariKerja, $bonus = 0, $potongan = 0);
    public function simpanGaji($data);
    public function getGajiByPeriode($periode);
}