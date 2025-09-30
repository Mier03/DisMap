<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('diseases')->insert([
            // Non-Communicable Diseases
            [
                'name' => 'Cardiovascular Disease',
                'specification' => 'Ischemic Heart Disease',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cardiovascular Disease',
                'specification' => 'Hypertensive Diseases',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cerebrovascular Disease',
                'specification' => 'Stroke',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Diabetes',
                'specification' => 'Diabetes Mellitus',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Chronic Respiratory Disease',
                'specification' => 'Chronic Obstructive Pulmonary Disease (COPD)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Chronic Kidney Disease',
                'specification' => 'End-Stage Renal Disease',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Neoplasms',
                'specification' => 'Breast Cancer',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Neoplasms',
                'specification' => 'Lung Cancer',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Neoplasms',
                'specification' => 'Colon and Rectum Cancer',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Neoplasms',
                'specification' => 'Cervical Cancer',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Neoplasms',
                'specification' => 'Liver Cancer',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Infectious and Communicable Diseases
            [
                'name' => 'Dengue',
                'specification' => 'Dengue Fever',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Dengue',
                'specification' => 'Dengue Hemorrhagic Fever',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tuberculosis',
                'specification' => 'Pulmonary Tuberculosis',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tuberculosis',
                'specification' => 'Extrapulmonary Tuberculosis',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Acute Respiratory Infection',
                'specification' => 'Pneumonia',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Acute Respiratory Infection',
                'specification' => 'Influenza',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'COVID-19',
                'specification' => 'COVID-19',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Diarrheal Disease',
                'specification' => 'Cholera',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Diarrheal Disease',
                'specification' => 'Dysentery',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Measles',
                'specification' => 'Measles',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Hepatitis',
                'specification' => 'Hepatitis A',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Hepatitis',
                'specification' => 'Hepatitis B',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Malaria',
                'specification' => 'Malaria',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Typhoid Fever',
                'specification' => 'Typhoid Fever',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Other Common Conditions
            [
                'name' => 'Meningitis',
                'specification' => 'Bacterial Meningitis',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Anemia',
                'specification' => 'Iron-deficiency Anemia',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Asthma',
                'specification' => 'Asthma',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Allergy',
                'specification' => 'Food Allergy',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Injury',
                'specification' => 'Road Traffic Injury',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Rabies',
                'specification' => 'Rabies',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Gastroenteritis',
                'specification' => 'Viral Gastroenteritis',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Leptospirosis',
                'specification' => 'Leptospirosis',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}