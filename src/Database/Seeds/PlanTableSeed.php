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
				'stripe_id'             => 'price_1IKPDtF4Su9xD29bO88BAheF',
				'stripe_environment'    => 'local',
				'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
			];
			
			$dataSave[] = [
				'name'                  => 'Envio de XML por api',
				'description'           => '<li>Envio por api</li><li>Arquivos XML</li>',
				'status'                => Plan::STATUS_INACTIVE,
				'value'                 => (double)10.00,
				'email_notify'          => Plan::STATUS_INACTIVE,
				'api_notify'            => Plan::STATUS_ACTIVE,
				'notify_email_pdf'      => Plan::STATUS_INACTIVE,
				'notify_api_xml'        => Plan::STATUS_ACTIVE,
				'notify_email_50_news'  => Plan::STATUS_INACTIVE,
				'notify_api_all_news'   => Plan::STATUS_INACTIVE,
				'notify_api_50_news'    => Plan::STATUS_INACTIVE,
				'stripe_id'             => 'price_1IKPEaF4Su9xD29b4PEPtzwn',
				'stripe_environment'    => 'local',
				'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
			];
			
			$dataSave[] = [
				'name'                  => 'Todas as noticias por api',
				'description'           => '<li>Envio por api</li><li>Todas as notícias</li>',
				'status'                => Plan::STATUS_INACTIVE,
				'value'                 => (double)30.00,
				'email_notify'          => Plan::STATUS_INACTIVE,
				'api_notify'            => Plan::STATUS_ACTIVE,
				'notify_email_pdf'      => Plan::STATUS_INACTIVE,
				'notify_api_xml'        => Plan::STATUS_INACTIVE,
				'notify_email_50_news'  => Plan::STATUS_INACTIVE,
				'notify_api_all_news'   => Plan::STATUS_ACTIVE,
				'notify_api_50_news'    => Plan::STATUS_INACTIVE,
				'stripe_id'             => 'price_1IKPGHF4Su9xD29bp0ialBKN',
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
				'stripe_id'             => 'price_1IKPFkF4Su9xD29b1HXNeIgM',
				'stripe_environment'    => 'local',
				'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
			];
			
			$dataSave[] = [
				'name'                  => '50 noticias por api',
				'description'           => '<li>Envio por api</li><li>Até 50 notícias diárias</li><li>Possibilidade de filtro</li>',
				'status'                => Plan::STATUS_INACTIVE,
				'value'                 => (double)15.00,
				'email_notify'          => Plan::STATUS_INACTIVE,
				'api_notify'            => Plan::STATUS_ACTIVE,
				'notify_email_pdf'      => Plan::STATUS_INACTIVE,
				'notify_api_xml'        => Plan::STATUS_INACTIVE,
				'notify_email_50_news'  => Plan::STATUS_INACTIVE,
				'notify_api_all_news'   => Plan::STATUS_INACTIVE,
				'notify_api_50_news'    => Plan::STATUS_ACTIVE,
				'stripe_id'             => 'price_1IKPGqF4Su9xD29bofh5eMDq',
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
					'stripe_id'             => 'price_1IKOx7F4Su9xD29bdytnTWOB',
					'stripe_environment'    => 'production',
					'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				];
				
				$dataSave[] = [
					'name'                  => 'Envio de XML por api',
					'description'           => '<li>Envio por api</li><li>Arquivos XML</li>',
					'status'                => Plan::STATUS_INACTIVE,
					'value'                 => (double)10.00,
					'email_notify'          => Plan::STATUS_INACTIVE,
					'api_notify'            => Plan::STATUS_ACTIVE,
					'notify_email_pdf'      => Plan::STATUS_INACTIVE,
					'notify_api_xml'        => Plan::STATUS_ACTIVE,
					'notify_email_50_news'  => Plan::STATUS_INACTIVE,
					'notify_api_all_news'   => Plan::STATUS_INACTIVE,
					'notify_api_50_news'    => Plan::STATUS_INACTIVE,
					'stripe_id'             => 'price_1IKOznF4Su9xD29bEcdWeZUp',
					'stripe_environment'    => 'production',
					'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				];
				
				$dataSave[] = [
					'name'                  => 'Todas as noticias por api',
					'description'           => '<li>Envio por api</li><li>Todas as notícias</li>',
					'status'                => Plan::STATUS_INACTIVE,
					'value'                 => (double)30.00,
					'email_notify'          => Plan::STATUS_INACTIVE,
					'api_notify'            => Plan::STATUS_ACTIVE,
					'notify_email_pdf'      => Plan::STATUS_INACTIVE,
					'notify_api_xml'        => Plan::STATUS_INACTIVE,
					'notify_email_50_news'  => Plan::STATUS_INACTIVE,
					'notify_api_all_news'   => Plan::STATUS_ACTIVE,
					'notify_api_50_news'    => Plan::STATUS_INACTIVE,
					'stripe_id'             => 'price_1IKP8TF4Su9xD29b5WlSthpy',
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
					'stripe_id'             => 'price_1IKP40F4Su9xD29b54QagmnS',
					'stripe_environment'    => 'production',
					'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				];
				
				$dataSave[] = [
					'name'                  => '50 noticias por api',
					'description'           => '<li>Envio por api</li><li>Até 50 notícias diárias</li><li>Possibilidade de filtro</li>',
					'status'                => Plan::STATUS_INACTIVE,
					'value'                 => (double)15.00,
					'email_notify'          => Plan::STATUS_INACTIVE,
					'api_notify'            => Plan::STATUS_ACTIVE,
					'notify_email_pdf'      => Plan::STATUS_INACTIVE,
					'notify_api_xml'        => Plan::STATUS_INACTIVE,
					'notify_email_50_news'  => Plan::STATUS_INACTIVE,
					'notify_api_all_news'   => Plan::STATUS_INACTIVE,
					'notify_api_50_news'    => Plan::STATUS_ACTIVE,
					'stripe_id'             => 'price_1IKPAoF4Su9xD29b39QD4qFY',
					'stripe_environment'    => 'production',
					'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
					'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
				];
			}
			
			Plan::insert($dataSave);
		}
		
	}
}
