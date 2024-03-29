<?php

namespace App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


class LocaleSubscriber implements EventSubscriberInterface{
    
    private $defaultLocale;
    public function __construct(string $defaultLocale="en") {
        $this->defaultLocale=$defaultLocale;
    }
    
    public function onKernelRequest(GetResponseEvent $event){
        $request=$event->getRequest();
        if(!$request->hasPreviousSession()){
            return;
        }
        
        if($locale=$request->attributes->get('locale')){
            $request->getSession()->set('_locale',$locale);
        }else{
            $request->setLocale($request->getSession()->get('_locale',$this->defaultLocale));
        }
    }
    
    
    public static function getSubscribedEvents() 
            {
        return [
            KernelEvents::REQUEST=>[['onKernelRequest',17]]
        ];
    }
}