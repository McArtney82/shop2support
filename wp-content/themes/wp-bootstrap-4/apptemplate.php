<?php
/*
  Template Name: App Template
*/

get_header();

$sw_name = (str_replace(' ', '-', strtolower(get_the_title())) . '-sw.js'); //for the service worker

$offers = get_field('offers', get_the_ID());

$categories_id = array_unique(array_reduce($offers, function($carry, $item) {
    $cats = get_the_category($item);

    foreach($cats as $cat) {
        $carry[] = $cat->term_id;
    }

    return $carry;
}));

$categories = array_map(function ($x) {
    return [
        'id'   => $x->term_id,
        'name' => html_entity_decode($x->name),
    ];
}, get_terms([
    'taxonomy' => 'category',
    'include' => $categories_id,
    'orderby' => 'name',
    'order'   => 'ASC',
]));
?>

<div class="page-single">
    <main class="page-single__content" role="main">

        <?php if (have_posts()) :
            while (have_posts()) : the_post(); ?>

                <div class="_mb-8 _bg-gray-700">
                    <div class="o-container _py-12">
                        <div class="_text-white">
                            <?php the_content() ?>
                        </div>
                        <div id="vm-search" data-placeholder="Search offers on <?= get_the_title(); ?>">
                            <!-- Vue.js code will be injected here -->
                        </div>
                    </div>
                </div>
            <?php endwhile ?>
        <?php endif; ?>

        <div id="vm-offers"
             data-user-id="<?= get_current_user_id() ?>"
             data-post-id="<?= get_the_ID() ?>"
             data-categories="<?= htmlspecialchars(json_encode($categories)); ?>">
            <!-- Vue.js code will be injected here -->
        </div>

        <div class="modal" tabindex="-1" role="dialog" id="login-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">User Not Logged In</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>You need to login or register to save to favourites</strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary lrm-register" data-dismiss="modal">
                            Login/Register
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info" role="alert" id="chrome-install-prompt" style="height:100%">
            <strong>Shop2Support</strong>
            <button id="btnAdd" type="button" class="btn btn-secondary" style="float:right">
                Install App
            </button>
            <a href="#" id="alert-close">
                Close and use website
            </a>
        </div>

    </main>
</div>

<script src="https://www.gstatic.com/firebasejs/5.8.6/firebase.js"></script>
<script>
    console.log('got here')
    // Initialize Firebase
    var config = {
        apiKey: 'AIzaSyAiKSmUFpAGcvlaFrV5NiBrXSRGOD1YKNk',
        authDomain: 'whatson-pwa-f2af4.firebaseapp.com',
        databaseURL: 'https://whatson-pwa-f2af4.firebaseio.com',
        projectId: 'whatson-pwa-f2af4',
        storageBucket: 'whatson-pwa-f2af4.appspot.com',
        messagingSenderId: '1027836744584'
    }
    firebase.initializeApp(config)

    if ('serviceWorker' in navigator) {
        navigator.serviceWorker
            .register('<?php echo get_site_url(); ?>/<?php echo $sw_name?>')
            .then(function (reg) {
                firebase.messaging().useServiceWorker(reg)
                console.log('Service Worker Registered')
                console.log(reg)
                reg.pushManager.getSubscription().then(function (sub) {
                    if (sub === null) {
                        // Update UI to ask user to register for Push
                        console.log('Not subscribed to push service!')
                    } else {
                        // We have a subscription, update the database
                        console.log('Subscription object: ', sub)
                    }
                })
            })
    }
    if ('PushManager' in window) {
        console.log('Push Notifications Allowed')
    } else {
        console.log('Push Notifications Not Allowed')
    }

    //Notification.requestPermission(function(status) {
    //console.log('Notification permission status:', status);
    //});
    String.prototype.replaceAll = function (str1, str2, ignore) {
        return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g, '\\$&'), (ignore ? 'gi' : 'g')), (typeof (str2) == 'string') ? str2.replace(/\$/g, '$$$$') : str2)
    }
    var theme_assets_images = "<?php echo get_template_directory_uri() . '/assets/images'; ?>"

    var isIphone = navigator.userAgent.indexOf('iPhone') != -1
    var isIpod = navigator.userAgent.indexOf('iPod') != -1
    var isIpad = navigator.userAgent.indexOf('iPad') != -1

    var isIos = isIphone || isIpad
    console.log('iPod:' + isIpod)
    console.log('iPad:' + isIpad)
    console.log('iPhone:' + isIphone)
    let isInWebAppiOS = (window.navigator.standalone == true);

    //var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
    var isChrome = (navigator.userAgent.match('CriOS'))

    let deferredPrompt

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault()
        // Stash the event so it can be triggered later.
        deferredPrompt = e
        console.log('install prompt ready')
        jQuery('#chrome-install-prompt').toggle('slide')

    })

    jQuery(function () {
        jQuery(document).on('lrm/before_display/registration', function () {
            jQuery('#login-modal').modal('hide')
            jQuery('input[name=username]').focus()
        })
        console.log('is ios web app:' + isInWebAppiOS)
        var loading = jQuery.loading({
            imgPath: '<?php echo get_template_directory_uri() . "/assets/js/img/"?>ajax-loading.gif'
        })

        jQuery('#btnAdd').click(function (e) {
            e.preventDefault()
            jQuery('#chrome-install-prompt').hide()
            // Show the prompt
            deferredPrompt.prompt()
            // Wait for the user to respond to the prompt
            deferredPrompt.userChoice
                .then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the A2HS prompt')
                    } else {
                        console.log('User dismissed the A2HS prompt')
                    }
                    deferredPrompt = null
                })
        })

        iPhoneInstallOverlay.init({
            blurElement: '.page-single',
            spritesURL: theme_assets_images + '/mobile-sprite.png',
            appName: 'Shop2Support'
        })

        if (isIos && !isInWebAppiOS && !isChrome) {
            iPhoneInstallOverlay.showOverlay()
            if (isIpad) {
                console.log('hiding pointer')
                jQuery('.icon-homePointer.sprite-mobile').css('display', 'none')
            }

        }

        if (isIos && !isInWebAppiOS && isChrome) {
            jQuery('#chrome-install-prompt').hide()
        }

    })

    jQuery('#alert-close').on('click', function () {
        jQuery('#chrome-install-prompt').hide()
    })
</script>

<?php get_footer(); ?>
