<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
<div id="container">

<header>
    <h1>Admin Portal Berita</h1>
</header>

<nav>
    <a href="<?= base_url('/admin'); ?>">Dashboard</a>
    <a href="<?= base_url('/admin/artikel'); ?>">Artikel</a>
    <a href="<?= base_url('/admin/artikel/add'); ?>">Tambah Artikel</a>

    <!-- LOGIN INFO -->
    <?php if (session()->get('logged_in')): ?>
        <span style="color:#fff; margin-left:20px;">
            Admin: <?= session()->get('user_name'); ?>
        </span>
        <a href="<?= base_url('/user/logout'); ?>" style="float:right;">
            Logout
        </a>
    <?php endif; ?>
</nav>

<section id="wrapper">
<section id="main">