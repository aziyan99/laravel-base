<template>
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
            data-class="c-sidebar-show">
            <i class="c-icon c-icon-lg c-icon cil-menu"></i>
        </button>
        <a class="c-header-brand d-lg-none" href="#">
            <b>WEB-NAME</b>
        </a>
        <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
            data-class="c-sidebar-lg-show" responsive="true">
            <i class="c-icon-lg c-icon cil-menu"></i>
        </button>
        <ul class="c-header-nav d-md-down-none">
            <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Dashboard</a></li>
            <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Users</a></li>
            <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Settings</a></li>
        </ul>
        <ul class="c-header-nav ml-auto mr-4">
            <li class="c-header-nav-item d-md-down-none mx-2">
                <a class="c-header-nav-link" href="#">
                    <i class="c-icon-lg c-icon cil-bell"></i>
                </a>
            </li>
            <li class="c-header-nav-item dropdown">
                <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="c-avatar"><img class="c-avatar-img"
                            src="/assets/backend/assets/img/avatars/6.jpg" alt="user@email.com">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <strong>Settings</strong>
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="mr-3 c-icon cil-user"></i>
                        Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <i class="mr-3 c-icon cil-account-logout"></i>Logout</a>
                </div>
            </li>
        </ul>
        <div class="c-subheader px-3">
            <!-- Breadcrumb-->
            <ol class="breadcrumb border-0 m-0">
                <li class="breadcrumb-item">Backoffice</li>
                <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">Admin</router-link></li>
                <li class="breadcrumb-item active">{{ pageTitle }}</li>
                <!-- Breadcrumb Menu-->
            </ol>
        </div>
    </header>
</template>
<script>
export default {
    data(){
        return{
            pageTitle:'',
        }
    },
    created(){
        Fire.$on('PageChange', (data) => {
            this.pageTitle = data.title;
        });
    }
}
</script>
