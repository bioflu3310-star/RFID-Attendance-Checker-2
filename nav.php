<?php
/**
 * nav.php
 * Shared navigation bar included by every page.
 * Usage: include 'nav.php';
 * Set $activePage before including, e.g. $activePage = 'home';
 * Valid values: 'home' | 'userdata' | 'registration' | 'readtag'
 */

$navLinks = [
    'home'         => ['href' => 'home.php',         'label' => 'Home'],
    'userdata'     => ['href' => 'user_data.php',    'label' => 'User Data'],
    'registration' => ['href' => 'registration.php', 'label' => 'Registration'],
    'readtag'      => ['href' => 'read_tag.php',     'label' => 'Read Tag ID'],
];
?>

<ul class="topnav">
    <?php foreach ($navLinks as $key => $link): ?>
        <li>
            <a href="<?= $link['href'] ?>"
               class="<?= ($activePage === $key) ? 'active' : '' ?>">
                <?= $link['label'] ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
