<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataRequest;
use Carbon\Carbon;

class DataRequestSeeder extends Seeder
{
    public function run()
    {
        $dataRequests = [
            [
                'name' => 'Maria Santos',
                'email' => 'maria.santos@email.com',
                'purpose' => 'Academic research for university thesis about disease patterns in urban areas',
                'requested_type' => 'statistics',
                'requested_disease' => 'Cancer',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'John Smith',
                'email' => 'john.smith@research.org',
                'purpose' => 'Public health analysis for non-profit organization',
                'requested_type' => 'statistics',
                'requested_disease' => 'Diabetes',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'name' => 'Dr. Lisa Garcia',
                'email' => 'lisa.garcia@hospital.com',
                'purpose' => 'Medical conference presentation on regional health trends',
                'requested_type' => 'statistics',
                'requested_disease' => 'Hypertension',
                'status' => 'approved',
                'handled_by_admin_id' => 1, // Assuming admin user with id 1 exists
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'name' => 'Barangay Health Worker Association',
                'email' => 'contact@bhw-assoc.ph',
                'purpose' => 'Community health program planning and resource allocation',
                'requested_type' => 'statistics',
                'requested_disease' => 'Tuberculosis',
                'status' => 'rejected',
                'handled_by_admin_id' => 1,
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'name' => 'University of Public Health',
                'email' => 'research@uph.edu.ph',
                'purpose' => 'Comparative study of disease prevalence across different regions',
                'requested_type' => 'statistics',
                'requested_disease' => 'Cardiovascular Diseases',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ];

        foreach ($dataRequests as $request) {
            DataRequest::create($request);
        }
    }
}