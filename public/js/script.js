"use strict";

function createCookie(name, value, days) {

    let expires;

    if (days) {
        let data = new Date;
        Date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }

    document.cookie = name + "=" + value + expires + "; path=/";
}