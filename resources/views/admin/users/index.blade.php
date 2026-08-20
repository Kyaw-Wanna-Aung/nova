@extends('layouts.admin')

@section('title', 'User & Role Management')
@section('page_title', 'User & Role Management')
@section('page_subtitle', 'Manage users, roles, and permissions within the admin panel.')

@section('content')

<div class="space-y-6">

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center gap-3 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header & Action Buttons --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold text-[var(--navy)]">
                Users & Roles
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Create and manage system users, roles, and group permissions.
            </p>
        </div>

        <div class="flex flex-wrap gap-2.5">
            <button
                type="button"
                onclick="openCreateUserModal()"
                class="grad-a rounded-xl px-4 py-2.5 text-sm font-semibold text-white glow transition hover:opacity-90 cursor-pointer"
            >
                + Add User
            </button>
            <button
                type="button"
                onclick="openAddRoleModal()"
                class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 cursor-pointer"
            >
                + Add Role
            </button>
            <button
                type="button"
                onclick="openGroupPermissionModal()"
                class="rounded-xl bg-amber-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-700 cursor-pointer"
            >
                Group Permissions
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card p-5 bg-white border border-slate-200 rounded-2xl shadow-sm">
        <form
            method="GET"
            action="{{ route('admin.users.index') }}"
            class="grid gap-3 md:grid-cols-3"
        >
            <div>
                <label class="text-xs font-semibold text-slate-500 block mb-1">Search User</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm outline-none"
                    placeholder="Search username or email..."
                >
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-500 block mb-1">Filter by Role</label>
                <select name="role" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm outline-none">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="flex-1 rounded-xl bg-[var(--navy)] px-4 py-2.5 text-sm font-semibold text-white cursor-pointer"
                >
                    Filter
                </button>
                <a
                    href="{{ route('admin.users.index') }}"
                    class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-500 flex items-center justify-center"
                >
                    Clear
                </a>
            </div>
        </form>
    </div>

    {{-- Users Table --}}
    <div class="card overflow-hidden bg-white border border-slate-200 rounded-2xl shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-[#FBFCFD] text-left text-xs uppercase tracking-wide text-slate-400">
                        <th class="px-5 py-4">ID</th>
                        <th class="px-5 py-4">Username</th>
                        <th class="px-5 py-4">Email</th>
                        <th class="px-5 py-4">Role</th>
                        <th class="px-5 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    @php
                        $userName = $user->username ?? $user->first_name;
                    @endphp
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                        <td class="px-5 py-4 font-semibold text-slate-700">{{ $user->id }}</td>
                        <td class="px-5 py-4 font-medium text-slate-800">{{ $userName }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $user->email }}</td>
                        <td class="px-5 py-4">
                            <div class="flex flex-wrap gap-1">
                                @forelse($user->roles as $userRole)
                                    <span class="rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-600">
                                        {{ $userRole->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-slate-400 italic">No Role</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="inline-flex items-center justify-end gap-2">
                                {{-- Individual User Permission Button --}}
                                <button
                                    type="button"
                                    onclick='openUserPermissionModal(@json($user))'
                                    class="rounded-lg bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-600 hover:bg-amber-100 cursor-pointer"
                                >
                                    Permissions
                                </button>

                                <button
                                    type="button"
                                    onclick='openEditUserModal(@json($user))'
                                    class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-[var(--navy)] text-xs font-medium cursor-pointer"
                                >
                                    Edit
                                </button>

                                <button
                                    type="button"
                                    onclick="if(confirm('Delete this user?')) document.getElementById('delete-user-form-{{ $user->id }}').submit();"
                                    class="rounded-lg p-2 text-slate-400 hover:bg-rose-50 hover:text-rose-500 text-xs font-medium cursor-pointer"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>

                    <form id="delete-user-form-{{ $user->id }}" method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center text-slate-500">
                            <p class="font-semibold">No users found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-100 px-5 py-4">
            {{ $users->links() }}
        </div>
    </div>
</div>


{{-- MODAL 1: Create / Edit User Modal --}}
<div id="userModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <div>
                <h3 id="userModalTitle" class="text-lg font-bold text-[var(--navy)]">Add New User</h3>
                <p class="text-sm text-slate-500">Fill in user details and assign a role.</p>
            </div>
            <button type="button" onclick="closeUserModal()" class="text-slate-400 cursor-pointer">✕</button>
        </div>

        <form id="userForm" method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div id="userMethodField"></div>

            <div class="max-h-[70vh] space-y-4 overflow-y-auto px-6 py-5">
                <div>
                    <label class="text-sm font-medium text-slate-600 block mb-1.5">Username / Name</label>
                    <input id="username" name="username" type="text" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none" required>
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600 block mb-1.5">Email Address</label>
                    <input id="email" name="email" type="email" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none" required>
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600 block mb-1.5">Password</label>
                    <input name="password" type="password" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none" placeholder="Leave blank to keep current if editing">
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-600 block mb-1.5">Role</label>
                    <select id="user_role_select" name="role" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm outline-none" required>
                        <option value="">-- Choose Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button type="button" onclick="closeUserModal()" class="flex-1 rounded-xl border border-slate-200 py-2.5 text-sm font-semibold text-slate-600 cursor-pointer">Cancel</button>
                <button id="userSubmitButton" type="submit" class="grad-a flex-1 rounded-xl py-2.5 text-sm font-semibold text-white cursor-pointer">Save User</button>
            </div>
        </form>
    </div>
</div>


{{-- MODAL 2: Add Role Modal --}}
<div id="roleModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
    <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <div>
                <h3 class="text-lg font-bold text-[var(--navy)]">Add New Role</h3>
                <p class="text-sm text-slate-500">Create a new system role.</p>
            </div>
            <button type="button" onclick="closeRoleModal()" class="text-slate-400 cursor-pointer">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf
            <div class="space-y-4 px-6 py-5">
                <div>
                    <label class="text-sm font-medium text-slate-600 block mb-1.5">Role Name</label>
                    <input name="name" type="text" class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none" required>
                </div>
            </div>

            <div class="flex gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button type="button" onclick="closeRoleModal()" class="flex-1 rounded-xl border border-slate-200 py-2.5 text-sm font-semibold text-slate-600 cursor-pointer">Cancel</button>
                <button type="submit" class="rounded-xl bg-emerald-600 flex-1 py-2.5 text-sm font-semibold text-white cursor-pointer">Save Role</button>
            </div>
        </form>
    </div>
</div>


{{-- MODAL 3: Group Permissions Modal --}}
<div id="groupPermissionModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <div>
                <h3 class="text-lg font-bold text-[var(--navy)]">Group Permissions</h3>
                <p class="text-sm text-slate-500">Assign permissions to a role group.</p>
            </div>
            <button type="button" onclick="closeGroupPermissionModal()" class="text-slate-400 cursor-pointer">✕</button>
        </div>

        <form method="POST" action="{{ route('admin.roles.permissions') }}">
            @csrf
            <div class="max-h-[70vh] space-y-4 overflow-y-auto px-6 py-5">
                <div>
                    <label class="text-sm font-medium text-slate-600 block mb-1.5">Select Role</label>
                    <select name="role_id" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm outline-none" required>
                        <option value="">-- Choose Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-600 block mb-1.5">Permissions</label>
                    <div class="max-h-48 overflow-y-auto space-y-2 rounded-xl border border-slate-200 p-3 bg-slate-50">
                        @foreach ($permissions as $permission)
                            <label class="flex items-center gap-2.5 text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="rounded border-slate-300 text-amber-600">
                                <span>{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button type="button" onclick="closeGroupPermissionModal()" class="flex-1 rounded-xl border border-slate-200 py-2.5 text-sm font-semibold text-slate-600 cursor-pointer">Cancel</button>
                <button type="submit" class="rounded-xl bg-amber-600 flex-1 py-2.5 text-sm font-semibold text-white cursor-pointer">Save Group Permissions</button>
            </div>
        </form>
    </div>
</div>


{{-- MODAL 4: Individual User Permission Modal --}}
<div id="userPermissionModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/40 p-4 backdrop-blur-sm">
    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
            <div>
                <h3 class="text-lg font-bold text-[var(--navy)]">User Permissions</h3>
                <p class="text-sm text-slate-500">Manage direct permissions for this user.</p>
            </div>
            <button type="button" onclick="closeUserPermissionModal()" class="text-slate-400 cursor-pointer">✕</button>
        </div>

        <form id="userPermissionForm" method="POST" action="#">
            @csrf
            <div class="max-h-[70vh] space-y-4 overflow-y-auto px-6 py-5">
                <input type="hidden" id="perm_user_id" name="user_id">
                <div>
                    <label class="text-sm font-medium text-slate-600 block mb-1.5">Permissions Checkbox</label>
                    <div class="max-h-48 overflow-y-auto space-y-2 rounded-xl border border-slate-200 p-3 bg-slate-50">
                        @foreach ($permissions as $permission)
                            <label class="flex items-center gap-2.5 text-sm text-slate-700 cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="user-perm-checkbox rounded border-slate-300 text-amber-600">
                                <span>{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4">
                <button type="button" onclick="closeUserPermissionModal()" class="flex-1 rounded-xl border border-slate-200 py-2.5 text-sm font-semibold text-slate-600 cursor-pointer">Cancel</button>
                <button type="submit" class="rounded-xl bg-amber-600 flex-1 py-2.5 text-sm font-semibold text-white cursor-pointer">Save Permissions</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- User Modal Scripts ---
    const userModal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');
    const userMethodField = document.getElementById('userMethodField');
    const userModalTitle = document.getElementById('userModalTitle');
    const userSubmitButton = document.getElementById('userSubmitButton');

    window.openCreateUserModal = function() {
        userForm.reset();
        userForm.action = "{{ route('admin.users.store') }}";
        userMethodField.innerHTML = '';
        userModalTitle.textContent = 'Add New User';
        userSubmitButton.textContent = 'Save User';
        userModal.classList.remove('hidden');
        userModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    window.openEditUserModal = function(user) {
        userForm.reset();
        userForm.action = "/admin/users/" + user.id;
        userMethodField.innerHTML = '@method("PUT")';
        document.getElementById('username').value = user.username || user.first_name || '';
        document.getElementById('email').value = user.email || '';
        if (user.roles && user.roles.length > 0) {
            document.getElementById('user_role_select').value = user.roles[0].name;
        }
        userModalTitle.textContent = 'Edit User';
        userSubmitButton.textContent = 'Save Changes';
        userModal.classList.remove('hidden');
        userModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    window.closeUserModal = function() {
        userModal.classList.add('hidden');
        userModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    // --- Role Modal Scripts ---
    const roleModal = document.getElementById('roleModal');
    window.openAddRoleModal = function() {
        roleModal.classList.remove('hidden');
        roleModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }
    window.closeRoleModal = function() {
        roleModal.classList.add('hidden');
        roleModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    // --- Group Permission Modal Scripts ---
    const groupPermissionModal = document.getElementById('groupPermissionModal');
    window.openGroupPermissionModal = function() {
        groupPermissionModal.classList.remove('hidden');
        groupPermissionModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }
    window.closeGroupPermissionModal = function() {
        groupPermissionModal.classList.add('hidden');
        groupPermissionModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    // --- User Permission Modal Scripts ---
    const userPermissionModal = document.getElementById('userPermissionModal');
    window.openUserPermissionModal = function(user) {
        document.getElementById('perm_user_id').value = user.id;
        document.getElementById('userPermissionForm').action = "/admin/users/" + user.id + "/permissions"; // Adjust route as needed
        
        // Reset checkboxes
        document.querySelectorAll('.user-perm-checkbox').forEach(cb => cb.checked = false);
        if (user.permissions) {
            user.permissions.forEach(p => {
                const cb = document.querySelector(`.user-perm-checkbox[value="${p.name}"]`);
                if (cb) cb.checked = true;
            });
        }

        userPermissionModal.classList.remove('hidden');
        userPermissionModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }
    window.closeUserPermissionModal = function() {
        userPermissionModal.classList.add('hidden');
        userPermissionModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    // Close Modals on backdrop click or Escape key
    window.addEventListener('click', (event) => {
        if (event.target === userModal) closeUserModal();
        if (event.target === roleModal) closeRoleModal();
        if (event.target === groupPermissionModal) closeGroupPermissionModal();
        if (event.target === userPermissionModal) closeUserPermissionModal();
    });

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeUserModal();
            closeRoleModal();
            closeGroupPermissionModal();
            closeUserPermissionModal();
        }
    });
});
</script>
@endpush