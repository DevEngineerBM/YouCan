<template>
  <div>
    <h1>Create Product</h1>
    <form @submit.prevent="handleSubmit">
      <div>
        <label for="product-name">Product Name:</label>
        <input id="product-name" v-model="newProduct.name" placeholder="Product Name" />
      </div>
      <div>
        <label for="product-price">Product Price:</label>
        <input id="product-price" v-model.number="newProduct.price" placeholder="Product Price" type="number" />
      </div>
      <div>
        <label for="product-description">Product Description:</label>
        <textarea id="product-description" v-model="newProduct.description" placeholder="Product Description"></textarea>
      </div>
      <div>
        <label for="product-image">Product Image:</label>
        <input id="product-image" type="file" @change="handleImageChange" />
      </div>
      <div>
        <label for="product-category">Product Category:</label>
        <div v-for="(category, index) in categories" :key="category.id">
          <input type="checkbox" :id="'category-' + category.id" :value="category.id" v-model="newProduct.category_ids" />
          <label :for="'category-' + category.id">{{ category.name }}</label>
        </div>
      </div>
      <button type="submit" :disabled="loading">Create Product</button>
      <div v-if="loading">Creating...</div>
      <div v-if="error">{{ error }}</div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
//original 
const newProduct = ref({
  name: '',
  price: 0,
  description: '',
  image: null,
  category_ids: [] 
});

const loading = ref(false);
const error = ref('');
const categories = ref([]);

const fetchCategories = async () => {
  try {
    const response = await axios.get('/api/categories');
    categories.value = response.data;
  } catch (err) {
    error.value = `Error fetching categories: ${err.message}`;
  }
};

onMounted(fetchCategories);

const router = useRouter();

const handleSubmit = async () => {

  loading.value = true;
  error.value = '';
  const formData = new FormData();
  formData.append('name', newProduct.value.name);
  formData.append('description', newProduct.value.description);
  formData.append('price', newProduct.value.price);
  if (newProduct.value.image) {
    formData.append('image', newProduct.value.image);

  }

  // Append category IDs correctly we we be able to select multiple categories
 newProduct.value.category_ids.forEach(categoryId => {

    formData.append('category_ids[]', categoryId);

  }); 

  try {

    const response = await axios.post('/api/products', formData, {

      headers: {
        'Content-Type': 'multipart/form-data'
      }

    });

    newProduct.value = {
      name: '',
      price: 0,
      description: '',
      image: null,
      category_ids: []
    };

    router.push({ name: 'products.index' });

  } catch (err) {

    error.value = `Error creating product: ${err.message}`;

  } finally {

    loading.value = false;

  }
};

const handleImageChange = (event) => {
  const file = event.target.files[0];
  newProduct.value.image = file;
};
</script>

<style scoped>

</style>