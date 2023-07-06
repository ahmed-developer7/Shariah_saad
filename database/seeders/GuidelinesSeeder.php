<?php

namespace Database\Seeders;

use App\Models\Guideline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuidelinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Real Estate Income Generating Program Guidelines', 'heading' => 'Guidelines for Funds',
                'link' => 'data/guidelines/real_estate_income_generating_program_guidelines.pdf'],
            ['name' => 'Real Estate Income Generating Fund Guidelines', 'heading' => 'Guidelines for Funds',
                'link' => 'data/guidelines/real_estate_income_generating_fund_guidelines.pdf'],
            ['name' => 'Real Estate Development Guidelines', 'heading' => 'Guidelines for Funds',
                'link' => 'data/guidelines/real_estate_development_guidelines.pdf'],
            ['name' => 'Public Equity Fund Guidelines', 'heading' => 'Guidelines for Funds',
                'link' => 'data/guidelines/public_equity_fund_guidelines.pdf'],
            ['name' => 'Murabaha Fund Guidelines', 'heading' => 'Guidelines for Funds',
                'link' => 'data/guidelines/murabaha_fund_guidelines.pdf'],
            ['name' => 'Money Market Fund Guidelines', 'heading' => 'Guidelines for Funds',
                'link' => 'data/guidelines/money_market_fund_guidelines.pdf'],
            ['name' => 'Purchase of Securrency', 'heading' => 'Guidelines for Products',
                'link' => 'data/guidelines/purchase_of_securrency.pdf'],
            ['name' => 'Tawarroq Product Guidelines', 'heading' => 'Guidelines for Products',
                'link' => 'data/guidelines/tawarroq_product_guidelines.pdf'],
            ['name' => 'Murabaha Home Financing Product', 'heading' => 'Guidelines for Products',
                'link' => 'data/guidelines/murabaha_home_financing_product.pdf'],
            ['name' => 'Wa’ad for Debt Conversion Structure', 'heading' => 'Guidelines for Products',
                'link' => 'data/guidelines/waad_for_debt_conversion_structure.pdf'],
            ['name' => 'Income Fund Guideline', 'heading' => 'Guidelines for Structure',
                'link' => 'data/guidelines/income_fund_guideline.pdf']
        ];

        foreach ($data as $datum) {
            Guideline::create([
                'name' => $datum['name'],
                'heading' => $datum['heading'],
                'link' => $datum['link']
            ]);
        }
    }
}
