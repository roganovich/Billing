/** Пользователи */
import UsersCurrent from './components/users/UsersCurrent.vue';
/** Счета */
import AccountsIndex from './components/accounts/AccountsIndex.vue';
import AccountsCreate from './components/accounts/AccountsCreate.vue';
import AccountsEdit from './components/accounts/AccountsEdit.vue';
/** Операции */
import OperationsIndex from './components/operations/OperationsIndex.vue';
import OperationsCreate from './components/operations/OperationsCreate.vue';
import OperationsEdit from './components/operations/OperationsEdit.vue';

export const routes = [
    /** Users */
    {
        name: 'users_current',
        path: '/cabinet/personal',
        component: UsersCurrent,
    },
    /** Accounts */
    {
        name: 'accounts_index',
        path: '/cabinet/acocunts/index',
        component: AccountsIndex,
    },
    {
        name: 'accounts_create',
        path: '/cabinet/acocunts/create',
        component: AccountsCreate,
    },
    {
        name: 'accounts_edit',
        path: '/cabinet/acocunts/edit/:id',
        component: AccountsEdit,
    },
    /** Operations */
    {
        name: 'operations_index',
        path: '/cabinet/operations/index',
        component: OperationsIndex,
    },
    {
        name: 'operations_index',
        path: '/cabinet/operations/create',
        component: OperationsCreate,
    },
    {
        name: 'operations_edit',
        path: '/cabinet/operations/edit/:id',
        component: OperationsEdit,
    },
];
