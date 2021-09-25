self.addEventListener('push', function (e) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    console.log(e);

    if (e.data) {
        var msg = e.data.json();
        console.log(msg)
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon,
            actions: msg.actions
        }));
    }
});

// install
self.addEventListener('install', event => {
    console.log('installing…');
});

// activate
self.addEventListener('activate', event => {
    console.log('now ready to handle fetches!');
});

// fetch
// self.addEventListener('fetch', event => {
//     console.log('now fetch!',event);
// });

self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    if (event.action === 'openHomepage') {
        clients.openWindow('/');
    } else if(event.action === 'openSettingpage') {
        clients.openWindow("/user");
    }
  }, false
);

// self.notificationActions = {

//     openHomepage: function (customData) {
//         clients.openWindow('http://127.0.0.1:8000');
//     //   window.open('http://127.0.0.1:8000')
//     }
//   };
