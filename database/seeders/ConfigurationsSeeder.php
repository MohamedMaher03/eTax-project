<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigurationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuration::create(['key'=>'About', 'value'=> 'تغطي منظومة التحقق من قسيمة الراتب جميع مجالات التحقق الخاصة
                            بالعاملين بكافة انواعهم المسجلين بمنظومة توحيد احتساب صرائب
                            المرتبات متضمنه التحقق الخاص الافراد حاملي الجنسية المصرية
                            والاجانب العاملين بمصر لكافة القطاعات المسجلة بمنظومة توحيد
                            واحتساب ضرائب الدخل' ]);
        Configuration::create(['key'=>'Footer', 'value'=> 'من خلال هذه المنظومة يمكنك الاستعلام و التحقق من الشئون الضريبية لدى
                            الجهات الأخرى و التحقق من مستند الرواتب الخاص بالمواطن للتأكد من
                            صحتة' ]);
    }
}
