/** Пользователи */
import UsersCurrent from './components/users/UsersCurrent.vue';
/** Счета */
import AccountsIndex from './components/accounts/AccountsIndex.vue';
import AccountsCreate from './components/accounts/AccountsCreate.vue';
import AccountsEdit from './components/accounts/AccountsEdit.vue';
import AccountsView from './components/accounts/AccountsView.vue';
import AccountsPayment from './components/accounts/AccountsPayment.vue';

/** Операции */
import OperationsIndex from './components/operations/OperationsIndex.vue';
import OperationsView from './components/operations/OperationsView.vue';

export const routes = [
    {
        name: 'cabinet',
        path: '/cabinet',
        component: UsersCurrent,
    },
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
    {
        name: 'accounts_view',
        path: '/cabinet/acocunts/view/:id',
        component: AccountsView,
    },
    {
        name: 'accounts_payment',
        path: '/cabinet/acocunts/payment/:id',
        component: AccountsPayment,
    },
    /** Operations */
    {
        name: 'operations_index',
        path: '/cabinet/operations/index',
        component: OperationsIndex,
    },
    {
        name: 'operations_view',
        path: '/cabinet/operations/view/:id',
        component: OperationsView,
    },
];
