import { createRouter, createWebHistory } from 'vue-router'
import ProductsIndex from '../views/products/ProductsIndex.vue'
import ProductCreate from '../views/products/ProductCreate.vue'
import ProductEdit from '../views/products/ProductEdit.vue'
import ProductShow from '../views/products/ProductShow.vue'
import CategoryIndex from '../views/categories/CategoryIndex.vue'
import CategoryCreate from '../views/categories/CategoryCreate.vue'
import CategoryEdit from '../views/categories/CategoryEdit.vue'
import CategoryShow from '../views/categories/CategoryShow.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    //products
    {
      path: '/products',
      name: 'products.index',
      component: ProductsIndex
    },
    {
      path: '/products/create',
      name: 'products.create',
      component: ProductCreate
    },
    {
     path: '/products/:id',
      name: 'products.show',
      component: ProductShow
    },
    {
      path: '/products/:id/edit',
      name: 'products.edit',
      component: ProductEdit,
      props: true
    },
    // Categories routes
    {
      path: '/categories',
      name: 'categories.index',
      component: CategoryIndex
    },
    {
      path: '/categories/create',
      name: 'categories.create',
      component: CategoryCreate
    },
    {
      path: '/categories/:id',
      name: 'categories.show',
      component: CategoryShow,
    },
    {
      path: '/categories/:id/edit',
      name: 'categories.edit',
      component: CategoryEdit,
      props: true
    }
  ]
})


export default router;