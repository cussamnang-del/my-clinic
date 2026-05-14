<aside class="sidebar-wrapper" data-simplebar="true">
  <div class="sidebar-header">
    <div>
      <img src="{{ asset('assets/backend') }}/images/logo-icon.png" class="logo-icon" alt="logo icon">
    </div>
    <div>
      <h4 class="logo-text">Clinic</h4>
    </div>
    <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i>
    </div>
  </div>
  <!--navigation-->
  <ul class="metismenu" id="menu">
    <li>
      <a href="{{ route('admin.dashboard') }}">
        <div class="parent-icon"><i class="fadeIn animated bx bx-home-smile"></i>
        </div>
        <div class="menu-title">{{ trans('global.dashboard') }}</div>
      </a>
    </li>

    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="fadeIn animated bx bx-user"></i>
        </div>
        <div class="menu-title">{{ trans('cruds.user.title') }}</div>
      </a>
      <ul>
        <li> <a href="{{ route('admin.permissions.index') }}"><i
              class="bi bi-arrow-right-short"></i>{{ trans('cruds.permission.title') }}</a>
        </li>
        <li> <a href="{{ route('admin.roles.index') }}"><i
              class="bi bi-arrow-right-short"></i>{{ trans('cruds.role.title') }}</a>
        </li>
        <li> <a href="{{ route('admin.users.index') }}"><i
              class="bi bi-arrow-right-short"></i>{{ trans('cruds.user.title') }}</a>
        </li>
      </ul>
    </li>

    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="fadeIn animated bx bx-user-circle"></i>
        </div>
        <div class="menu-title">{{ trans('cruds.customer.title') }}</div>
      </a>
      <ul>
        <li>
          <a href="{{ route('admin.documents.index') }}"><i
              class="bi bi-arrow-right-short"></i>{{ trans('cruds.document.title') }}</a>
        </li>
        <li>
          <a href="{{ route('admin.document_lives.index') }}"><i
              class="bi bi-arrow-right-short"></i>{{ trans('cruds.document_life.title') }}</a>
        </li>
        <li>
          <a href="{{ route('admin.document_life_details.index') }}"><i
              class="bi bi-arrow-right-short"></i>{{ trans('cruds.document_life_detail.title') }}</a>
        </li>
        <li>
          <a href="{{ route('admin.customers.index') }}"><i
              class="bi bi-arrow-right-short"></i>{{ trans('cruds.customer.title') }}</a>
        </li>
      </ul>
    </li>

    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="fadeIn animated bx bx-shopping-bag"></i>
        </div>
        <div class="menu-title">{{ trans('cruds.product.title') }}</div>
      </a>
      <ul>
        <li>
          <a href="{{ route('admin.products.index') }}"><i
              class="fadeIn animated bx bx-restaurant"></i>{{ trans('cruds.product.title') }}</a>
        </li>
        <li>
          <a href="{{ route('admin.rooms.index') }}"><i
              class="fadeIn animated bx bx-store-alt"></i>{{ trans('cruds.room.title') }}</a>
        </li>
      </ul>
    </li>

    <li>
      <a href="{{ route('admin.histories.showHistory') }}">
        <div class="parent-icon"><i class="fadeIn animated bx bx-history"></i>
        </div>
        <div class="menu-title">{{ trans('cruds.customer_history.title') }}</div>
      </a>
    </li>

    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="fadeIn animated bx bx-shopping-bag"></i>
        </div>
        <div class="menu-title">{{ trans('cruds.schedule.title') }}</div>
      </a>
      <ul>
        <li>
          <a href="{{ route('admin.schedules.index') }}">
            <div class="parent-icon"><i class="fadeIn animated bx bx-history"></i>
            </div>
            <div class="menu-title">{{ trans('cruds.schedule.title') }}</div>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.schedules.showCalendar') }}">
            <div class="parent-icon"><i class="fadeIn animated bx bx-history"></i>
            </div>
            <div class="menu-title">Calendar</div>
          </a>
        </li>
      </ul>
    </li>

    <li>
      <a href="{{ route('admin.lifesigns.index') }}">
        <div class="parent-icon"><i class="fadeIn animated bx bx-health"></i>
        </div>
        <div class="menu-title">{{ trans('cruds.lifesign.title') }}</div>
      </a>
    </li>

    <li>
      <a href="javascript:;" class="has-arrow">
        <div class="parent-icon"><i class="fadeIn animated bx bx-camera"></i>
        </div>
        <div class="menu-title">{{ trans('cruds.labo.title') }}</div>
      </a>
      <ul>
        <li>
          <a href="{{ route('admin.item_groups.index') }}">
            <div class="parent-icon"><i class="fadeIn animated bx bx-detail"></i>
            </div>
            <div class="menu-title">{{ trans('cruds.item_group.title') }}</div>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.item_types.index') }}">
            <div class="parent-icon"><i class="fadeIn animated bx bx-detail"></i>
            </div>
            <div class="menu-title">{{ trans('cruds.item_type.title') }}</div>
          </a>
        </li>
        <li>
          <a href="{{ route('admin.items.index') }}">
            <div class="parent-icon"><i class="fadeIn animated bx bx-detail"></i>
            </div>
            <div class="menu-title">{{ trans('cruds.item.title') }}</div>
          </a>
        </li>
      </ul>
    </li>

    <li>
      <a href="{{ route('admin.company_informations.index') }}">
        <div class="parent-icon"><i class="fadeIn animated bx bx-health"></i>
        </div>
        <div class="menu-title">{{ trans('cruds.company_information.title') }}</div>
      </a>
    </li>
  </ul>
  <!--end navigation-->
</aside>
