<?php


namespace Oka6\DouApi\Database\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Oka6\DouApi\Models\Plan;

class PlanTableSeed extends Seeder {
	
	public function run() {
		if(!Plan::count()){
			$dataSave = [];
			$dataSave[] = [
				'name'                  => 'Envio de PDF por email',
				'description'           => '<li>Envio por email</li><li>Arquivos PDF</li>',
				'status'                => Plan::STATUS_ACTIVE,
				'value'                 => (double)10.00,
				'email_notify'          => Plan::STATUS_ACTIVE,
				'api_notify'            => Plan::STATUS_INACTIVE,
				'notify_email_pdf'      => Plan::STATUS_ACTIVE,
				'notify_api_xml'        => Plan::STATUS_INACTIVE,
				'notify_email_50_news'  => Plan::STATUS_INACTIVE,
				'notify_api_all_news'   => Plan::STATUS_INACTIVE,
				'notify_api_50_news'    => Plan::STATUS_INACTIVE,
				'stripe_id'             => 'prod_IwHnllu7UbVzvN',
				'stripe_environment'    => 'local',
				'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
			];
			
			$dataSave[] = [
				'name'                  => 'Envio de XML por api',
				'description'           => '<li>Envio por api</li><li>Arquivos XML</li>',
				'status'                => Plan::STATUS_ACTIVE,
				'value'                 => (double)10.00,
				'email_notify'          => Plan::STATUS_INACTIVE,
				'api_notify'            => Plan::STATUS_ACTIVE,
				'notify_email_pdf'      => Plan::STATUS_INACTIVE,
				'notify_api_xml'        => Plan::STATUS_ACTIVE,
				'notify_email_50_news'  => Plan::STATUS_INACTIVE,
				'notify_api_all_news'   => Plan::STATUS_INACTIVE,
				'notify_api_50_news'    => Plan::STATUS_INACTIVE,
				'stripe_id'             => 'prod_IwHoiN3v6lTc2N',
				'stripe_environment'    => 'local',
				'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
			];
			
			$dataSave[] = [
				'name'                  => 'Todas as noticias por api',
				'description'           => '<li>Envio por api</li><li>Todas as notícias</li>',
				'status'                => Plan::STATUS_ACTIVE,
				'value'                 => (double)30.00,
				'email_notify'          => Plan::STATUS_INACTIVE,
				'api_notify'            => Plan::STATUS_ACTIVE,
				'notify_email_pdf'      => Plan::STATUS_INACTIVE,
				'notify_api_xml'        => Plan::STATUS_INACTIVE,
				'notify_email_50_news'  => Plan::STATUS_INACTIVE,
				'notify_api_all_news'   => Plan::STATUS_ACTIVE,
				'notify_api_50_news'    => Plan::STATUS_INACTIVE,
				'stripe_id'             => 'prod_IwHpNprodcfPz9',
				'stripe_environment'    => 'local',
				'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
			];
			
			$dataSave[] = [
				'name'                  => '50 noticias por email',
				'description'           => '<li>Envio por email</li><li>Até 50 notícias diárias</li><li>Possibilidade de filtro</li>',
				'status'                => Plan::STATUS_ACTIVE,
				'value'                 => (double)15.00,
				'email_notify'          => Plan::STATUS_ACTIVE,
				'api_notify'            => Plan::STATUS_INACTIVE,
				'notify_email_pdf'      => Plan::STATUS_INACTIVE,
				'notify_api_xml'        => Plan::STATUS_INACTIVE,
				'notify_email_50_news'  => Plan::STATUS_ACTIVE,
				'notify_api_all_news'   => Plan::STATUS_INACTIVE,
				'notify_api_50_news'    => Plan::STATUS_INACTIVE,
				'stripe_id'             => 'prod_IwHpcX8FfQ1brH',
				'stripe_environment'    => 'local',
				'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
			];
			
			$dataSave[] = [
				'name'                  => '50 noticias por api',
				'description'           => '<li>Envio por api</li><li>Até 50 notícias diárias</li><li>Possibilidade de filtro</li>',
				'status'                => Plan::STATUS_ACTIVE,
				'value'                 => (double)15.00,
				'email_notify'          => Plan::STATUS_INACTIVE,
				'api_notify'            => Plan::STATUS_ACTIVE,
				'notify_email_pdf'      => Plan::STATUS_INACTIVE,
				'notify_api_xml'        => Plan::STATUS_INACTIVE,
				'notify_email_50_news'  => Plan::STATUS_INACTIVE,
				'notify_api_all_news'   => Plan::STATUS_INACTIVE,
				'notify_api_50_news'    => Plan::STATUS_ACTIVE,
				'stripe_id'             => 'prod_IwHqgCZW3K5iQc',
				'stripe_environment'    => 'local',
				'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
			];
			
			
			
			
			if (App::environment('production')) {
				/** Production */
				$dataSave[] = [
					'name'                  => 'Envio de PDF por email',
					'description'           => '<li>Envio por email</li><li>Arquivos PDF</li>',
					'status'                => Plan::STATUS_ACTIVE,
					'value'                 => (double)10.00,
					'email_notify'          => Plan::STATUS_ACTIVE,
					'api_notify'            => Plan::STATUS_INACTIVE,
					'notify_email_pdf'      => Plan::STATUS_ACTIVE,
					'notify_api_xml'        => Plan::STATUS_INACTIVE,
					'notify_email_50_news'  => Plan::STATUS_INACTIVE,
					'notify_api_all_news'   => Plan::STATUS_INACTIVE,
					'notify_api_50_news'    => Plan::STATUS_INACTIVE,
					'stripe_id'             => 'prod_IwHWqtu5ofAWw7',
					'stripe_environment'    => 'production',
					'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				];
				
				$dataSave[] = [
					'name'                  => 'Envio de XML por api',
					'description'           => '<li>Envio por api</li><li>Arquivos XML</li>',
					'status'                => Plan::STATUS_ACTIVE,
					'value'                 => (double)10.00,
					'email_notify'          => Plan::STATUS_INACTIVE,
					'api_notify'            => Plan::STATUS_ACTIVE,
					'notify_email_pdf'      => Plan::STATUS_INACTIVE,
					'notify_api_xml'        => Plan::STATUS_ACTIVE,
					'notify_email_50_news'  => Plan::STATUS_INACTIVE,
					'notify_api_all_news'   => Plan::STATUS_INACTIVE,
					'notify_api_50_news'    => Plan::STATUS_INACTIVE,
					'stripe_id'             => 'prod_IwHY7xFTQ4XqWm',
					'stripe_environment'    => 'production',
					'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				];
				
				$dataSave[] = [
					'name'                  => 'Todas as noticias por api',
					'description'           => '<li>Envio por api</li><li>Todas as notícias</li>',
					'status'                => Plan::STATUS_ACTIVE,
					'value'                 => (double)30.00,
					'email_notify'          => Plan::STATUS_INACTIVE,
					'api_notify'            => Plan::STATUS_ACTIVE,
					'notify_email_pdf'      => Plan::STATUS_INACTIVE,
					'notify_api_xml'        => Plan::STATUS_INACTIVE,
					'notify_email_50_news'  => Plan::STATUS_INACTIVE,
					'notify_api_all_news'   => Plan::STATUS_ACTIVE,
					'notify_api_50_news'    => Plan::STATUS_INACTIVE,
					'stripe_id'             => 'prod_IwHhidKunIzOyh',
					'stripe_environment'    => 'production',
					'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				];
				
				$dataSave[] = [
					'name'                  => '50 noticias por email',
					'description'           => '<li>Envio por email</li><li>Até 50 notícias diárias</li><li>Possibilidade de filtro</li>',
					'status'                => Plan::STATUS_ACTIVE,
					'value'                 => (double)15.00,
					'email_notify'          => Plan::STATUS_ACTIVE,
					'api_notify'            => Plan::STATUS_INACTIVE,
					'notify_email_pdf'      => Plan::STATUS_INACTIVE,
					'notify_api_xml'        => Plan::STATUS_INACTIVE,
					'notify_email_50_news'  => Plan::STATUS_ACTIVE,
					'notify_api_all_news'   => Plan::STATUS_INACTIVE,
					'notify_api_50_news'    => Plan::STATUS_INACTIVE,
					'stripe_id'             => 'prod_IwHdReZQ075b3U',
					'stripe_environment'    => 'production',
					'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				];
				
				$dataSave[] = [
					'name'                  => '50 noticias por api',
					'description'           => '<li>Envio por api</li><li>Até 50 notícias diárias</li><li>Possibilidade de filtro</li>',
					'status'                => Plan::STATUS_ACTIVE,
					'value'                 => (double)15.00,
					'email_notify'          => Plan::STATUS_INACTIVE,
					'api_notify'            => Plan::STATUS_ACTIVE,
					'notify_email_pdf'      => Plan::STATUS_INACTIVE,
					'notify_api_xml'        => Plan::STATUS_INACTIVE,
					'notify_email_50_news'  => Plan::STATUS_INACTIVE,
					'notify_api_all_news'   => Plan::STATUS_INACTIVE,
					'notify_api_50_news'    => Plan::STATUS_ACTIVE,
					'stripe_id'             => 'prod_IwHk3gddViRhWW',
					'stripe_environment'    => 'production',
					'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				];
				
				
			}
			
			Plan::insert($dataSave);
		}
		
	}
}
