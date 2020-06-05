var waypoint = new Waypoint({
    element: document.getElementById('p5'),
    handler: function() {
        notify('Basic waypoint triggered')
    }
})