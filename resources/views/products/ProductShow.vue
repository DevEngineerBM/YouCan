<template>
  <div>
    <h1>Product Details</h1>
    <div v-if="loading">Loading product details...</div>
    <div v-else>
      <div v-if="error">{{ error }}</div>
      <div v-else>
        <h2>{{ product.name }}</h2>
        <p>Price: ${{ product.price }}</p>
        <p>Description: {{ product.description }}</p>
        <img :src="product.image" alt="Product Image" width="100" v-if="product.image">
        <div v-if="product.categories && product.categories.length > 0">
          <h4>Categories:</h4>
          <ul>
            <li v-for="category in product.categories" :key="category.id">
              <router-link :to="{ name: 'categories.show', params: { id: category.id } }">{{ category.name }}</router-link>
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
const product = ref({});
const loading = ref(false);
const error = ref('');

const fetchProductDetails = async () => {
  try {
    loading.value = true;
    const response = await axios.get(`/api/products/${route.params.id}`);
    product.value = response.data;
  } catch (err) {
    error.value = `Error fetching product details: ${err.message}`;
  } finally {
    loading.value = false;
  }
};

const router = useRouter();
const route = useRoute();

onMounted(fetchProductDetails);
</script>
