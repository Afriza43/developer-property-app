<?php

namespace App\Providers;

use App\Repositories\JobRepository;
use App\Repositories\RABRepository;
use App\Repositories\HouseRepository;
use App\Repositories\VolumeRepository;
use App\Repositories\ExpenseRepository;
use App\Repositories\ProgresRepository;
use App\Repositories\ProjectRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\EmployeeRepository;
use App\Repositories\MaterialRepository;
use App\Repositories\EquipmentRepository;
use App\Repositories\JobDetailRepository;
use App\Repositories\ProjectTypeRepository;
use App\Repositories\Interfaces\JobRepositoryInterface;
use App\Repositories\Interfaces\RABRepositoryInterface;
use App\Repositories\Interfaces\HouseRepositoryInterface;
use App\Repositories\Interfaces\VolumeRepositoryInterface;
use App\Repositories\Interfaces\ExpenseRepositoryInterface;
use App\Repositories\Interfaces\ProgresRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Repositories\Interfaces\MaterialRepositoryInterface;
use App\Repositories\Interfaces\EquipmentRepositoryInterface;
use App\Repositories\Interfaces\JobDetailRepositoryInterface;
use App\Repositories\Interfaces\ProjectTypeRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(HouseRepositoryInterface::class, HouseRepository::class);
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);
        $this->app->bind(ProgresRepositoryInterface::class, ProgresRepository::class);
        $this->app->bind(RABRepositoryInterface::class, RABRepository::class);
        $this->app->bind(EquipmentRepositoryInterface::class, EquipmentRepository::class);
        $this->app->bind(MaterialRepositoryInterface::class, MaterialRepository::class);
        $this->app->bind(JobDetailRepositoryInterface::class, JobDetailRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(VolumeRepositoryInterface::class, VolumeRepository::class);
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
        $this->app->bind(ProjectTypeRepositoryInterface::class, ProjectTypeRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
