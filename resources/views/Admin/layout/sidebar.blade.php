     <div class="sidebar-div">
         <button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn"><i
                 class="la la-close"></i></button>
         <div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-light ">
             <!-- BEGIN: Aside Menu -->
             {{-- m-aside-menu--skin-light --}}
             <div id="m_ver_menu" class="m-aside-menu  m-aside-menu skin-light m-aside-menu--submenu-skin-light "
                 m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
                 <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                     @if (AdminPrivileges() == 'super')
                         @include('Admin.layout.privileges.super')
                     @elseif(AdminPrivileges() == 'manager')
                         @include('Admin.layout.privileges.manager')
                     @elseif(AdminPrivileges() == 'cs')
                         @include('Admin.layout.privileges.cs')
                     @endif
                 </ul>
             </div>
             <!-- END: Aside Menu -->
         </div>
     </div>
