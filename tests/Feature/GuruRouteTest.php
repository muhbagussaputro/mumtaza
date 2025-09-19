<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_guru_dashboard_requires_authentication()
    {
        $response = $this->get('/guru/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_guru_data_siswa_requires_authentication()
    {
        $response = $this->get('/guru/data-siswa');
        $response->assertRedirect('/login');
    }

    public function test_guru_data_hafalan_requires_authentication()
    {
        $response = $this->get('/guru/data-hafalan');
        $response->assertRedirect('/login');
    }

    public function test_guru_hafalan_requires_authentication()
    {
        $response = $this->get('/guru/hafalan');
        $response->assertRedirect('/login');
    }

    public function test_guru_laporan_requires_authentication()
    {
        $response = $this->get('/guru/laporan');
        $response->assertRedirect('/login');
    }

    public function test_guru_siswa_requires_authentication()
    {
        $response = $this->get('/guru/siswa');
        $response->assertRedirect('/login');
    }

    public function test_guru_routes_exist()
    {
        $this->assertTrue(
            collect(app('router')->getRoutes())->pluck('uri')->contains('guru/dashboard')
        );

        $this->assertTrue(
            collect(app('router')->getRoutes())->pluck('uri')->contains('guru/data-siswa')
        );

        $this->assertTrue(
            collect(app('router')->getRoutes())->pluck('uri')->contains('guru/data-hafalan')
        );

        $this->assertTrue(
            collect(app('router')->getRoutes())->pluck('uri')->contains('guru/hafalan')
        );

        $this->assertTrue(
            collect(app('router')->getRoutes())->pluck('uri')->contains('guru/laporan')
        );

        $this->assertTrue(
            collect(app('router')->getRoutes())->pluck('uri')->contains('guru/siswa')
        );
    }
}
