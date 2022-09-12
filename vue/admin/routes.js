/** Статьи */
import WikiPagesIndex from './components/wikipages/WikiPagesIndex.vue'
import WikiPagesCreate from './components/wikipages/WikiPagesCreate.vue';
import WikiPagesEdit from './components/wikipages/WikiPagesEdit.vue';
/** Пользователи */
import UsersIndex from './components/users/UsersIndex.vue';
import UsersCreate from './components/users/UsersCreate.vue';
import UsersEdit from './components/users/UsersEdit.vue';
/** Счета */
import AccountsIndex from './components/accounts/AccountsIndex.vue';
import AccountsCreate from './components/accounts/AccountsCreate.vue';
import AccountsEdit from './components/accounts/AccountsEdit.vue';
import AccountsView from './components/accounts/AccountsView.vue';
/** Операции */
import OperationsIndex from './components/operations/OperationsIndex.vue';
import OperationsView from './components/operations/OperationsView.vue';

export const routes = [
    {
        name: 'admin',
        path: '/admin',
        component: WikiPagesIndex,
    },
    /** Wikipages */
    {
        name: 'wikipages_index',
        path: '/admin/wikipages',
        component: WikiPagesIndex,
    },
    {
        name: 'wikipages_create',
        path: '/admin/wikipages/create',
        component: WikiPagesCreate,
    },
    {
        name: 'wikipages_edit',
        path: '/admin/wikipages/edit/:id',
        component: WikiPagesEdit,
    },
    {
        name: 'users_index',
        path: '/admin/users',
        component: UsersIndex,
    },
    {
        name: 'users_create',
        path: '/admin/users/create',
        component: UsersCreate,
    },
    {
        name: 'users_edit',
        path: '/admin/users/edit/:id',
        component: UsersEdit,
    },
    /** Accounts */
    {
        name: 'accounts_index',
        path: '/admin/acocunts/index',
        component: AccountsIndex,
    },
    {
        name: 'accounts_create',
        path: '/admin/acocunts/create',
        component: AccountsCreate,
    },
    {
        name: 'accounts_edit',
        path: '/admin/acocunts/edit/:id',
        component: AccountsEdit,
    },
    {
        name: 'accounts_view',
        path: '/admin/acocunts/view/:id',
        component: AccountsView,
    },
    /** Operations */
    {
        name: 'operations_index',
        path: '/admin/operations/index',
        component: OperationsIndex,
    },
    {
        name: 'operations_view',
        path: '/admin/operations/view/:id',
        component: OperationsView,
    },
];
