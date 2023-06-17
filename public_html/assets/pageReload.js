window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}

//Script used to reload the login page once: Updates the navbar Links when user disconnected