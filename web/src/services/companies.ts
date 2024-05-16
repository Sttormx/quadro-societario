import config from '../../config';
import axios, { AxiosResponse } from 'axios';

const instance = axios.create({
  baseURL: `${config.API_URL}/api`,
  headers: {
    Authorization: `Bearer ${localStorage.getItem('token') || ''}`
  }
});

const getCompanies = async (): Promise<Array<any>> => {
  try {
    const response: AxiosResponse = await instance.get('/companies');

    const data = response.data;
    if (response.status === 200) {
      return data.data;
    } else {
      throw new Error(data.message || 'failed');
    }
  } catch (error) {
    console.error('Error:', error);
    throw error;
  }
};

const createCompany = async (data: any): Promise<void> => {
    try {
        const response: AxiosResponse = await instance.post('/company', data);
    
        if (response.status === 200) {
          return;
        } else {
          throw new Error('failed');
        }
      } catch (error) {
        console.error('Error:', error);
        throw error;
      }
}

const delCompany = async (id: string): Promise<void> => {
    try {
        const response: AxiosResponse = await instance.delete(`/company/${id}`);
    
        if (response.status === 200) {
          return;
        } else {
          throw new Error('failed');
        }
      } catch (error) {
        console.error('Error:', error);
        throw error;
      }
}

const editCompany = async (id: string, data: any): Promise<void> => {
    try {
        const response: AxiosResponse = await instance.put(`/company/${id}`, data);
    
        if (response.status === 200) {
          return;
        } else {
          throw new Error('failed');
        }
      } catch (error) {
        console.error('Error:', error);
        throw error;
      }
}

const getCompany = async (id: string): Promise<any> => {
    try {
      const response: AxiosResponse = await instance.get(`/company/${id}`);
  
      const data = response.data;
      if (response.status === 200) {
        return data.data;
      } else {
        throw new Error(data.message || 'failed');
      }
    } catch (error) {
      console.error('Error:', error);
      throw error;
    }
  };

export { getCompanies, createCompany, delCompany, editCompany, getCompany };