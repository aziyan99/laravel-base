<template>
<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">
            <b>WEB-NAME</b>
        </div>
        <ul class="c-sidebar-nav">
            <li class="c-sidebar-nav-item">
                <router-link class="c-sidebar-nav-link" :to="{name: 'dashboard'}">
                    <i class="c-sidebar-nav-icon c-icon cil-speedometer"></i>
                    Dashbor
                </router-link>
            </li>
            <li class="c-sidebar-nav-title">Menu Utama</li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="javascript:;">
                    <i class="c-sidebar-nav-icon c-icon cil-shield-alt"></i>
                    Hak Akses & Keamanan
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <router-link class="c-sidebar-nav-link" :to="{name: 'role'}">
                            <span class="c-sidebar-nav-icon"></span>
                            Role
                        </router-link>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="javascript:;">
                            <span class="c-sidebar-nav-icon"></span>
                            Permissions
                        </a>
                    </li>
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="javascript:;">
                            <span class="c-sidebar-nav-icon"></span>
                            Assign Permissions
                        </a>
                    </li>
                </ul>
            </li>
            <li class="c-sidebar-nav-item">
                <router-link class="c-sidebar-nav-link" :to="{name: 'profile'}">
                    <i class="c-sidebar-nav-icon c-icon cil-user"></i>
                    Profil
                </router-link>
            </li>
        </ul>
    </div>
</template>
