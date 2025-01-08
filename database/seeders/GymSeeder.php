<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GymSeeder extends Seeder
{
    public function run()
    {
        $gyms = [
            [
                'name' => 'Fitness First Colombo',
                'address' => '123 Galle Road, Colombo 03',
                'latitude' => 6.8913,
                'longitude' => 79.8566,
                'phone' => '+94 11 234 5678',
                'email' => 'info@fitnessfirstcolombo.com',
                'description' => 'Premium fitness center in the heart of Colombo',
                'opening_hours' => json_encode([
                    'Monday-Friday' => '6:00 AM - 10:00 PM',
                    'Saturday-Sunday' => '7:00 AM - 8:00 PM'
                ]),
                'amenities' => json_encode(['Cardio Zone', 'Weight Training', 'Personal Training', 'Locker Rooms', 'Showers'])
            ],
            [
                'name' => 'Power World Gym',
                'address' => '45 Duplication Road, Colombo 04',
                'latitude' => 6.8865,
                'longitude' => 79.8587,
                'phone' => '+94 11 345 6789',
                'email' => 'contact@powerworldgym.lk',
                'description' => 'Comprehensive fitness facility with modern equipment',
                'opening_hours' => json_encode([
                    'Monday-Friday' => '5:30 AM - 11:00 PM',
                    'Saturday-Sunday' => '6:00 AM - 9:00 PM'
                ]),
                'amenities' => json_encode(['Strength Training', 'Cardio Equipment', 'Group Classes', 'Protein Bar'])
            ],
            [
                'name' => 'Gold\'s Gym Colombo',
                'address' => '78 Reid Avenue, Colombo 07',
                'latitude' => 6.9012,
                'longitude' => 79.8624,
                'phone' => '+94 11 456 7890',
                'email' => 'info@goldsgymcolombo.com',
                'description' => 'International standard gym with expert trainers',
                'opening_hours' => json_encode([
                    'Monday-Friday' => '6:00 AM - 10:30 PM',
                    'Saturday-Sunday' => '7:00 AM - 9:00 PM'
                ]),
                'amenities' => json_encode(['Cardio Center', 'Free Weights', 'Swimming Pool', 'Spa', 'Cafe'])
            ],
            [
                'name' => 'Colombo Fitness Hub',
                'address' => '234 R.A. De Mel Mawatha, Colombo 03',
                'latitude' => 6.8978,
                'longitude' => 79.8534,
                'phone' => '+94 11 567 8901',
                'email' => 'info@colombofitnesshub.lk',
                'description' => 'Modern gym with state-of-the-art equipment',
                'opening_hours' => json_encode([
                    'Monday-Friday' => '6:00 AM - 11:00 PM',
                    'Saturday-Sunday' => '6:30 AM - 9:00 PM'
                ]),
                'amenities' => json_encode(['CrossFit', 'Yoga Studio', 'Boxing Ring', 'Steam Room', 'Juice Bar'])
            ],
            [
                'name' => 'Flex Fitness Colombo',
                'address' => '567 Baseline Road, Colombo 09',
                'latitude' => 6.9234,
                'longitude' => 79.8644,
                'phone' => '+94 11 678 9012',
                'email' => 'contact@flexfitness.lk',
                'description' => 'Family-friendly fitness center with diverse programs',
                'opening_hours' => json_encode([
                    'Monday-Friday' => '5:00 AM - 10:00 PM',
                    'Saturday-Sunday' => '6:00 AM - 8:00 PM'
                ]),
                'amenities' => json_encode(['Kids Area', 'Ladies Only Section', 'Group Classes', 'Personal Training', 'Parking'])
            ],
            [
                'name' => 'Energy Zone Gym',
                'address' => '89 Marine Drive, Colombo 06',
                'latitude' => 6.8789,
                'longitude' => 79.8563,
                'phone' => '+94 11 789 0123',
                'email' => 'info@energyzone.lk',
                'description' => 'Beachfront gym with panoramic ocean views',
                'opening_hours' => json_encode([
                    'Monday-Sunday' => '24 Hours'
                ]),
                'amenities' => json_encode(['24/7 Access', 'Beach View', 'Recovery Zone', 'Supplements Shop', 'Cardio Deck'])
            ],
            [
                'name' => 'Body Perfect Gym',
                'address' => '123 Havelock Road, Colombo 05',
                'latitude' => 6.8934,
                'longitude' => 79.8598,
                'phone' => '+94 11 890 1234',
                'email' => 'info@bodyperfect.lk',
                'description' => 'Specialized in body transformation programs',
                'opening_hours' => json_encode([
                    'Monday-Friday' => '5:30 AM - 10:30 PM',
                    'Saturday-Sunday' => '6:00 AM - 9:00 PM'
                ]),
                'amenities' => json_encode(['Body Composition Analysis', 'Nutrition Counseling', 'Personal Training', 'Group Classes'])
            ]
        ];

        foreach ($gyms as $gym) {
            DB::table('gyms')->insert($gym);
        }
    }
}
