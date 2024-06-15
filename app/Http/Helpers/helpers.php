<?php

const DEFAULT_TIMEZONE = 'Asia/Karachi';
const DATE_FORMAT = 'Y-m-d';
const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

const PAGINATION_LIMIT = 15;
const NTH_SPONSOR_LIMIT = 3;
const URL_REGEX = 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';


function notifyUsers() {
    $a = \Brackets\AdminAuth\Models\AdminUser::all();
    \Notification::send($a, new \App\Notifications\UserSubscribed());
}