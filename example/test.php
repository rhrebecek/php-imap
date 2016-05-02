<?php

/**
 * Test example
 */

require_once __DIR__ . '/../src/Imap.php';

$imap = new \Rhrebecek\PHPMail\Imap(
    'username@example.com',
    'password',
    'localhost',
    143
);

$imap->noop();
$response = $imap->listMailboxes();
var_dump($response);
$imap->create('INBOX.test');
$imap->subscribe('INBOX.test');
$imap->unsubscribe('INBOX.test');
$response = $imap->status('INBOX.test', 'MESSAGES');
var_dump($response);

$message = 'Date: Mon, 7 Feb 2015 21:52:25 +0100 (PST)
From: Fred Foobar <foobar@hrebecek.cz>
Subject: afternoon meeting
To: rhrebecek@gmail.com
Message-Id: <B27397-0100000@hrebecek.cz>
MIME-Version: 1.0
Content-Type: TEXT/PLAIN; CHARSET=UTF-8

Hello John, do you think we can meet at 3:30 tomorrow?';

$response = $imap->append('INBOX.test', $message, '\Seen');
var_dump($response);

$response = $imap->select('INBOX.test');
var_dump($response);

$response = $imap->search('SINCE 1-Feb-2015');
var_dump($response);

$response = $imap->fetch('1', '(FLAGS BODY[HEADER.FIELDS (DATE FROM)])');
var_dump($response);

$imap->copy('1', 'INBOX.test');
$response = $imap->store('1:*', '+Flags', '\Deleted');
var_dump($response);

$response = $imap->expunge();
var_dump($response);

$imap->check();
$response = $imap->close();

$imap->rename('INBOX.test', 'INBOX.test2');
$imap->delete('INBOX.test2');

