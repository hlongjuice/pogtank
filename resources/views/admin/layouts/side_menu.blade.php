<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu">
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <div class="clearfix">
                </div>
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            </li>
            {{--Dashboard--}}
            <li class="start {{Request::path()=='admin'?'active':''}}">
                <a href="{{route('admin.dashboard')}}">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            {{--Product--}}
            <li class="{{Request::path()=='admin/product'?'active':''}}">
                <a href="{{route('admin.product.index')}}">
                    <i class="fab fa-product-hunt"></i>
                    <span class="title">สินค้า</span>
                </a>
            </li>
            {{--Ordering--}}
            <?php
            $orderingMenu = false;
            $orderingListMenu = false;
            $porlor4PartMenu = false;
            if (strpos(Request::path(),'admin/project_order')!==false) {
                $orderingMenu = true;
                $orderingListMenu = true;
            }else if(strpos(Request::path(),'admin/porlor_4_parts')!==false){
                $orderingMenu = true;
                $porlor4PartMenu = true;
            }
            ?>
            <li class="{{$orderingMenu?'open':''}}">
                <a href="javascript:;">
                    <i class="far fa-shopping-cart"></i>
                    <span class="title">ระบบ ปร.4,5,6</span>
                    <span class="selected"></span>
                    <span class="arrow {{$orderingMenu?'open':''}}"></span>
                </a>
                <ul class="sub-menu" style="display: {{$orderingMenu?'block':'none'}};">
                    {{--Porlor4PartMenu--}}
                    <li class="{{$porlor4PartMenu?'active':''}}">
                        <a href="{{route('admin.porlor_4_part.index')}}">
                            <span class="title">- หมวดหมู่ปร.4</span>
                        </a>
                    </li>
                    {{--OrderingListMenu--}}
                    <li class="{{$orderingListMenu?'active':''}}">
                        <a href="{{route('admin.project_order.index')}}">
                            <span class="title">- โครงการ</span>
                        </a>
                    </li>
                </ul>
            </li>
            {{--Materials--}}
            <?php
            $materialMenu = false;
            $materialItemMenu = false;
            $materialTypeMenu = false;
            if (
                Request::path() == 'admin/materials/types' ||
                Request::path() == 'admin/materials/types/create'
            ) {
                $materialMenu = true;
                $materialTypeMenu= true;
            }else if(
                Request::path() == 'admin/materials/items'||
                Request::path() == 'admin/materials/items/create'
            ){
                $materialMenu = true;
                $materialItemMenu =true;
            }
            ?>
            <li class="{{$materialMenu?'open':''}}">
                <a href="javascript:;">
                    <i class="far fa-wrench"></i>
                    <span class="title">วัสดุอุปกรณ์</span>
                    <span class="selected"></span>
                    <span class="arrow {{$materialMenu?'open':''}}"></span>
                </a>
                <ul class="sub-menu" style="display: {{$materialMenu?'block':'none'}};">
                    {{--Material Types--}}
                    <li class="{{$materialTypeMenu?'active':''}}">
                        <a href="{{route('admin.materials.types.index')}}">
                            - หมวดหมู่วัสดุ/อุปกรณ์</a>
                    </li>
                    {{--Material Item--}}
                    <li class="{{$materialItemMenu?'active':''}}">
                        <a href="{{route('admin.materials.items.index')}}">
                            - วัสดุ/อุปกรณ์</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->