import config from '../../config';
import axios, { AxiosResponse } from 'axios';

type LoginCredentials = {
  username: string;
  password: string;
};

const instance = axios.create({
  baseURL: `${config.API_URL}/api`,
});

const login = async (credentials: LoginCredentials): Promise<string> => {
  try {
    const response: AxiosResponse = await instance.post('/login', credentials);

    const data = response.data;
    if (response.status === 200) {
      localStorage.setItem('token', data.token);
      return data.token;
    } else {
      throw new Error(data.message || 'Authentication failed');
    }
  } catch (error) {
    console.error('Login Error:', error);
    throw error;
  }
};

const logout = (): void => {
  localStorage.removeItem('token');
};

export { login, logout };