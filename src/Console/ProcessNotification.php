<?php

namespace Oka6\DouApi\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Oka6\DouApi\Helpers\Helper;
use Oka6\Admin\Library\MongoUtils;
use Oka6\Admin\Models\User;
use Oka6\DouApi\Mail\News;
use Oka6\DouApi\Mail\Pdf;
use Oka6\DouApi\Models\Dou;
use Oka6\DouApi\Models\DouCategory;
use Oka6\DouApi\Models\DouType;
use Oka6\DouApi\Models\Notification;
use Oka6\DouApi\Models\Subscription;

class ProcessNotification extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'DouApi:ProcessNotification';
	
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description      = 'Process subscription valid';
	protected $folderZipAttach  = 'dou-zip-attachment/';
	protected $folderPdfAttach  = 'dou-pdf-attachment/';
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}
	
	public function getPathZipAttachment($file=''){
		if(!is_dir(storage_path('douapi/'.$this->folderZipAttach))){
			File::makeDirectory(storage_path('douapi/'.$this->folderZipAttach));
		}
		return storage_path('douapi/'.$this->folderZipAttach.$file);
	}
	public function getPathPdfAttachment($file=''){
		if(!is_dir(storage_path('douapi/'.$this->folderPdfAttach))){
			File::makeDirectory(storage_path('douapi/'.$this->folderPdfAttach));
		}
		return storage_path('douapi/'.$this->folderPdfAttach.$file);
	}
	
	public function handle() {
		$subscriptions = Subscription::getToNotify();
		foreach ($subscriptions as $subscription){
			$notification   = Notification::getLastNotification($subscription->_id);
			if($subscription->email){
				$this->sendEmail($subscription, $notification);
			}
			if($subscription->api){
				$this->sendApi($subscription, $notification);
			}
		}
	}
	
	public function sendEmail($subscription, $notification){
		$now            = new \DateTime();
		$user           = new User();
		$data['user']   = $user->getById($subscription->user_id);
		$status         = 1;
		$statusError    = 'Sucesso';
		
		if($subscription->notify_email_50_news){
			/** Verify send 50 news */
			if($notification && $notification->accumulated_dou_send>=50){
				Log::info('ProcessNotification sendEmail, notification has already reached the news limit', ['notification'=>$notification]);
				return false;
			}
			$dou    = Dou::getBySendToEmail($subscription->filter, $notification, 50);
			if(count($dou)){
				$ids = $dou->pluck('_id')->toArray();
				$data['news']           = $dou;
				$data['subscription']   = route('douapi.subscription.edit', [$subscription->_id]);
				$data['plan']           = $subscription->plan_name;
				try {
					Mail::to($subscription->email_notify)->send(new News($data));
				}catch (\Exception $e){
					$status         = 0;
					$statusError    = $e->getMessage();
				}
				Notification::createSend50News($status, $statusError, $subscription, $ids, $user, $notification);
			}
			
		}else if($subscription->notify_email_pdf && !$notification){
			$prefixFilePDFName  = $now->format('Y_m_d').'_*.pdf';
			$path               = $this->getPathPdfAttachment($prefixFilePDFName, GLOB_BRACE);
			$files              = [];
			foreach (glob($path) as $arquivo) {
				$files[] = ['name'=> basename($arquivo), 'link'=> route('douapi.subscription.read.pdf', [basename($arquivo)])];
			}
			$data['files']  = $files;
			if(!count($files)){
				return false;
			}
			try {
				Mail::to($subscription->email_notify)->send(new Pdf($data));
			}catch (\Exception $e){
				$status         = 0;
				$statusError    = $e->getMessage();
			}
			Notification::createSendPdf($status, $statusError, $subscription, $files, $user);
		}
	}
	
	public function sendApi($subscription, $notification){
	
	}
	
	public function makeFilter($filter, $alreadySend=null){
	
	}
	
	
	
}

