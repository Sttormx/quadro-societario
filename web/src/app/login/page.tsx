"use client";

import { login } from '@/services/auth';
import { useContext, useState } from 'react';
import { AuthContext } from '../contexts/auth';
import { useRouter } from 'next/navigation';

export default function Login() {
    const router = useRouter();
    const { setToken, setAuthenticated } = useContext(AuthContext);

    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    const handleSubmit = async (event: any) => {
        event.preventDefault();
        try {
            const token = await login({username: email, password});
            setToken(token);
            setAuthenticated(true);
            router.push('/companies');
        } catch (error) {
            alert('Verifique suas credenciais.')
        }
    };

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-900">
            <div className="p-8 bg-gray-800 rounded-lg shadow-lg max-w-md w-full">
                <form onSubmit={handleSubmit} className="space-y-6">
                    <h1 className="text-center text-3xl text-white">Login</h1>
                    <div>
                        <label htmlFor="email" className="text-sm font-medium text-gray-300">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            className="mt-1 block w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-md"
                            placeholder="Enter your email"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            required
                        />
                    </div>
                    <div>
                        <label htmlFor="password" className="text-sm font-medium text-gray-300">Password</label>
                        <input
                            type="password"
                            id="password"
                            className="mt-1 block w-full px-3 py-2 bg-gray-700 text-white border border-gray-600 rounded-md"
                            placeholder="Enter your password"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            required
                        />
                    </div>
                    <button type="submit" className="w-full px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md focus:bg-blue-700 focus:outline-none">
                        Log in
                    </button>
                </form>
            </div>
        </div>
    );
}
