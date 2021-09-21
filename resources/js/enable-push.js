module.exports = {
    urlBase64ToUint8Array: (base64String) => {
        var padding = '='.repeat((4 - base64String.length % 4) % 4);
        var base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');

        var rawData = window.atob(base64);
        var outputArray = new Uint8Array(rawData.length);

        for (var i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    },

    storePushSubscription: (pushSubscription) =>{
        const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

        axios.post('/api/webnotify', pushSubscription)
        .then((res) => {
            console.log(res)
        })
        .catch((err) => {
            console.log(err)
        });
    },

    subscribeUser: ()=>{
        navigator.serviceWorker.ready
        .then((registration) => {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: module.exports.urlBase64ToUint8Array(
                    String(process.env.MIX_VAPID_PUBLIC_KEY)
                )
            };
            return registration.pushManager.subscribe(subscribeOptions);
        })
        .then((pushSubscription) => {
            console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
            module.exports.storePushSubscription(pushSubscription);
        });
    },

    initPush: ()=>{
        if (!navigator.serviceWorker.ready) {
            return;
        }

        new Promise(function (resolve, reject) {
            const permissionResult = Notification.requestPermission(function (result) {
                resolve(result);
            });

            if (permissionResult) {
                permissionResult.then(resolve, reject);
            }
        })
        .then((permissionResult) => {
            if (permissionResult !== 'granted') {
                throw new Error('We weren\'t granted permission.');
            }
            module.exports.subscribeUser();
        });
    },

    initSW: () =>{
        if (!"serviceWorker" in navigator) {
            //service worker isn't supported
            return;
        }

        //don't use it here if you use service worker
        //for other stuff.
        if (!"PushManager" in window) {
            //push isn't supported
            return;
        }

        //register the service worker
        navigator.serviceWorker.register('/sw.js')
            .then((res) => {
                console.log('serviceWorker installed!')
                res.update();
                module.exports.initPush();
            })
            .catch((err) => {
                console.log(err)
            });
    }

}

// initSW();

// subscribeUser();
