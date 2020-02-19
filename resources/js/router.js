import Vue from 'vue';                                                                                        
import VueRouter from 'vue-router';
import ExampleComponent from "./components/ExampleComponent";
import TemplatesCreate from "./views/TemplatesCreate";
import TemplatesShow from "./views/TemplatesShow"
import TemplatesEdit from "./views/TemplatesEdit"
import TemplatesIndex from './views/TemplatesIndex';
Vue.use(VueRouter); 

export default new VueRouter({
    routes: [
        {path: '/', component: ExampleComponent},
        {path: '/templates', component: TemplatesIndex},
        {path: '/templates/create', component: TemplatesCreate, name: 'Create'},
        {path: '/templates/:id', component: TemplatesShow},
        {path: '/templates/:id/edit', component: TemplatesEdit}
    ],
    mode: 'history'
});