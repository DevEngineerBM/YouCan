<template>
  <div>
    <h1>Category Details</h1>
    <div v-if="loading">Loading category details...</div>
    <div v-else>
      <div v-if="error">{{ error }}</div>
      <div v-else>
        <h2>{{ category.name }}</h2>
        <p v-if="category.parent_id">Parent: {{ category.parent.name }}</p>

        <div v-if="category.children && category.children.length > 0">
          <h4>Subcategories:</h4>
          <ul>
            <li v-for="childCategory in category.children" :key="childCategory.id">
              {{ childCategory.name }}
            </li>
          </ul>
        </div>

        <div v-if="category.products && category.products.length > 0">
          <h4>Products:</h4>
          <ul>
            <li v-for="product in category.products" :key="product.id">
              <router-link :to="{ name: 'products.show', params: { id: product.id } }">{{ product.name }}</router-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';
//original 
const category = ref({});
const loading = ref(false);
const error = ref('');

const fetchCategoryDetails = async () => {

  try {

    loading.value = true;
    const response = await axios.get(`/api/categories/${route.params.id}`);
    category.value = response.data;

  } catch (err) {

    error.value = `Error fetching category details: ${err.message}`;

  } finally {

    loading.value = false;

  }
};

const router = useRouter();
const route = useRoute();

onMounted(fetchCategoryDetails);
</script>