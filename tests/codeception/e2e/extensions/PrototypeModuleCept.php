<?php

// @group mandatory

$I = new E2eTester($scenario);
$I->wantTo('ensure that Prototype works');

$I->amGoingTo('try to login with correct credentials');
$I->login('admin', 'admin1');

$I->amGoingTo('try to view and create snippets');
$I->amOnPage('/prototype');

$I->amOnPage('/prototype/less/create');
$I->waitForElementVisible('.giiant-crud button[type="submit"]');
$I->canSee('Create', 'button');

$I->amOnPage('/prototype/twig/create');
$I->waitForElementVisible('.giiant-crud button[type="submit"]');
$I->canSee('Create', 'button');

$I->amOnPage('/prototype/html/create');
$I->waitForElementVisible('.giiant-crud button[type="submit"]');
$I->canSee('Create', 'button');