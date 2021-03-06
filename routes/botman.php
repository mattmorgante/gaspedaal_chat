<?php
use App\Http\Controllers\BotManController;
use BotMan\BotMan\Messages\Attachments\Video;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\Element;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;
use BotMan\Drivers\Facebook\Extensions\ReceiptAddress;
use BotMan\Drivers\Facebook\Extensions\ReceiptAdjustment;
use BotMan\Drivers\Facebook\Extensions\ReceiptElement;
use BotMan\Drivers\Facebook\Extensions\ReceiptSummary;
use BotMan\Drivers\Facebook\Extensions\ReceiptTemplate;

$botman = resolve('botman');

$botman->hears('Hi', function($bot){
    $bot->reply(ButtonTemplate::create('Welcome to the Gaspedaal Bot. You can get started using the buttons below!')
        ->addButton(ElementButton::create('Ik zoek een auto')->type('postback')->payload('search'))
        ->addButton(ElementButton::create('I have a problem')->type('postback')->payload('problem'))
        ->addButton(ElementButton::create('I am a dealer')->type('postback')->payload('dealer'))
    );
});

$botman->hears('search', function($bot){
    $bot->reply(ButtonTemplate::create('Welke?')
        ->addButton(ElementButton::create('Most popular brands')->type('postback')->payload('Most popular brands'))
        ->addButton(ElementButton::create('Mooiest autos')->type('postback')->payload('expensive'))
        ->addButton(ElementButton::create('Goedkoope autos')->type('postback')->payload('cheapest'))
    );
});

$botman->hears('problem', function($bot){
    $bot->reply(ButtonTemplate::create('How can I help?')
    //My car isn’t shown on GP, how is that possible?
        ->addButton(ElementButton::create('My car is not on GP!')->type('postback')->payload('no car'))
    // Didn’t receive an email with registration confirmation link
        ->addButton(ElementButton::create('No email!')->type('postback')->payload('email'))
    // How do I get my car on GasPedaal.nl?
        ->addButton(ElementButton::create('Sell a car!')->type('postback')->payload('sell my car'))
    );

// I see my car on GasPedaal.nl, but the ad is not mine!/This car shouldn’t be on GasPedaal.nl. Can you delete it?

// Can you add [xxx] as a filter?

});


$botman->hears('expensive', function($bot){
    $bot->reply(GenericTemplate::create()
        ->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
        ->addElements([
            Element::create('Ferrari')
                ->subtitle('Zoek Ferrari occasions')
                ->image('http://static.corporate.ferrari.com/sites/ferrari15ipo/files/image-gallery/150069_car1.jpg')
                ->addButton(ElementButton::create('Ferraris on Gaspedaal')->url('https://beta.gaspedaal.nl/ferrari/')),
            Element::create('Porsche')
                ->subtitle('Zoek Porsche occasions')
                ->image('http://buyersguide.caranddriver.com/media/assets/submodel/7025.jpg')
                ->addButton(ElementButton::create('Porches on Gaspedaal')
                    ->url('https://beta.gaspedaal.nl/porsche/')
                ),
            Element::create('Mercedes-Benz')
                ->subtitle('Zoek Mercedes-Benz occasions')
                ->image('https://www.mercedes-benz.com/wp-content/uploads/sites/3/2015/08/00-mercedes-benz-vehicles-c-class-mercedes-amg-c-63-s-coupe-c-205-1280x686-1280x686.jpg')
                ->addButton(ElementButton::create('Mercedes-Benz on Gaspedaal')
                    ->url('https://beta.gaspedaal.nl/Mercedes-Benz/')
                )
        ])
    );
});

$botman->hears('cheapest', function($bot){
    $bot->reply(GenericTemplate::create()
        ->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
        ->addElements([
            Element::create('Renault')
                ->subtitle('Zoek Renault occasions')
                ->image('https://group.renault.com/wp-content/uploads/2014/08/Renault.jpg')
                ->addButton(ElementButton::create('Renaults on Gaspedaal')->url('https://beta.gaspedaal.nl/Renault/')),
            Element::create('Ford')
                ->subtitle('Zoek Ford occasions')
                ->image('https://upload.wikimedia.org/wikipedia/commons/thumb/8/81/2014_Ford_Fiesta_1.5L_Sport_in_Cyberjaya%2C_Malaysia_%2801%29.jpg/1200px-2014_Ford_Fiesta_1.5L_Sport_in_Cyberjaya%2C_Malaysia_%2801%29.jpg')
                ->addButton(ElementButton::create('Fords on Gaspedaal')
                    ->url('https://beta.gaspedaal.nl/ford/')
                ),
            Element::create('Opel')
                ->subtitle('Zoek Opel occasions')
                ->image('https://www.automotions.nl/sites/all/files/media/images/opel-ampera-e-299270.jpg')
                ->addButton(ElementButton::create('Opels on Gaspedaal')
                    ->url('https://beta.gaspedaal.nl/opel/')
                )
        ])
    );
});



$botman->hears('no car', function($bot){
    $bot->reply('jammer voor jouw!');
});

$botman->hears('email', function($bot){
    $bot->reply('check your spam, dummy');
});

$botman->hears('sell my car', function($bot){
    $bot->reply('u clearly do not understand how this shit works....');
});

$botman->hears('Show me some cars', function($bot){
    $bot->reply('https://beta.gaspedaal.nl');
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('Most popular brands', function($bot){
    $bot->reply(GenericTemplate::create()
        ->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
        ->addElements([
            Element::create('Audi')
                ->subtitle('Zoek Audi occasions')
                ->image('http://www.planwallpaper.com/static/images/Audi_R8_3_Quarter_75Souzo.jpg')
                ->addButton(ElementButton::create('Audis on Gaspedaal')->url('https://beta.gaspedaal.nl/audi/')),
            Element::create('BMW')
                ->subtitle('Zoek BMW occasions')
                ->image('http://www.telegraph.co.uk/content/dam/motoring2/2015/12/01/1-BMW-i8-main-xlarge-xlarge_trans_NvBQzQNjv4BqrWYeUU_H0zBKyvljOo6zlkYMapKPjdhyLnv9ax6_too.jpg')
                ->addButton(ElementButton::create('BMWs on Gaspedaal')
                    ->url('https://beta.gaspedaal.nl/bmw/')
                ),
            Element::create('Volkswagen')
                ->subtitle('Zoek Volkswagen occasions')
                ->image('http://static3.businessinsider.com/image/53bd4520eab8eaf83b61770e-1200-924/2014-volkswagen-passat-sport-static-2.jpg')
                ->addButton(ElementButton::create('Volkswagens on Gaspedaal')
                    ->url('https://beta.gaspedaal.nl/volkswagen/')
                )
        ])
    );
});

$botman->hears('I have a problem', function($bot){
    $bot->reply(ButtonTemplate::create('How can I help?')
        ->addButton(ElementButton::create('Test')->type('postback')->payload('Test'))
        ->addButton(ElementButton::create('Show me the docs')->url('http://botman.io/'))
    );
});

$botman->hears('dealer', function($bot){
    $bot->reply(ButtonTemplate::create('What would you like to do?')
        ->addButton(ElementButton::create('View my invoices')->type('postback')->payload('invoice'))
        ->addButton(ElementButton::create('View my occasions')->url('https://beta.gaspedaal.nl/mijn-aanbod'))
//        ->addButton(ElementButton::create('Video of a penguin')->type('postback')->payload('video'))
    );
});

$botman->hears('video', function($bot){
    $attachment = new Video('https://media.giphy.com/media/VkMV9TldsPd28/giphy.gif', [
        'custom_payload' => true,
    ]);

// Build message object
    $message = OutgoingMessage::create('Awww, penguins!!')
        ->withAttachment($attachment);

// Reply message object
    $bot->reply($message);
});

$botman->hears('invoice', function($bot){
    $bot->reply(
        ReceiptTemplate::create()
            ->recipientName('Christoph Rumpel')
            ->merchantName('BotMan GmbH')
            ->orderNumber('342343434343')
            ->timestamp('1428444852')
            ->orderUrl('http://test.at')
            ->currency('USD')
            ->paymentMethod('VISA')
            ->addElement(ReceiptElement::create('T-Shirt Small')->price(15.99)->image('http://botman.io/img/botman-body.png'))
            ->addElement(ReceiptElement::create('Sticker')->price(2.99)->image('http://botman.io/img/botman-body.png'))
            ->addAddress(ReceiptAddress::create()
                ->street1('Watsonstreet 12')
                ->city('Bot City')
                ->postalCode(100000)
                ->state('Washington AI')
                ->country('Botmanland')
            )
            ->addSummary(ReceiptSummary::create()
                ->subtotal(18.98)
                ->shippingCost(10 )
                ->totalTax(15)
                ->totalCost(23.98)
            )
            ->addAdjustment(ReceiptAdjustment::create('Laravel Bonus')->amount(5))
    );
});