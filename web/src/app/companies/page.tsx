'use client';

import { createCompany, delCompany, editCompany, getCompanies } from '@/services/companies';
import Link from 'next/link';
import React, { useEffect, useState } from 'react';

type Companies = {
  id: string
  name: string
  document: string
}

export default function TaskManager() {
  const [companies, setCompanies] = useState<Array<Companies>>([]);
  const [nameInput, setNameInput] = useState('');
  const [docInput, setDocInput] = useState('');
  const [editingId, setEditingId] = useState<string|null>(null);

  const [loaded, setLoaded] = useState(false);

  const loadCompanies = async () => {
    getCompanies().
      then((data) => {
        const companies = new Array<Companies>; 
        data.map((c) => companies.push({id: c.id, name: c.name, document: c.document}))

        setCompanies(companies);
      }).
      catch((err) => alert('Alguma coisa deu errado. Tente novamente mais tarde.'))
  }

  useEffect(() => {
    if (!loaded) {
      loadCompanies();
      setLoaded(true);
    }
  }, [loaded])

  const handleAdd = (e: any) => {
    e.preventDefault();

    createCompany({name: nameInput, document: docInput}).
      then(() => {
        setLoaded(false);
      }).
      catch((err) => alert('Alguma coisa deu errado. Tente novamente mais tarde.'))
  };

  const handleUpdate = (e: any) => {
    e.preventDefault();
    editCompany(editingId || '', {name: nameInput, document: docInput}).
      then(() => {
        setLoaded(false);
      }).
      catch((err) => alert('Alguma coisa deu errado. Tente novamente mais tarde.'))
  };

  const handleDelete = (id: any) => {
    delCompany(id).
      then(() => {
        setLoaded(false);
      }).
      catch((err) => alert('Alguma coisa deu errado. Tente novamente mais tarde.'))
  };

  const handleEdit = (id: string) => {
    const ToEdit = companies.find(c => c.id === id);
    if (ToEdit) {
      setNameInput(ToEdit.name);
      setDocInput(ToEdit.document);
    }
    setEditingId(id);
  };

  return (
    <div className="min-h-screen bg-gray-900 text-white p-10">
      <h1 className="text-3xl mb-4">Empresas</h1>
      <form onSubmit={editingId ? handleUpdate : handleAdd} className="mb-6">
        <input
          type="text"
          value={nameInput}
          onChange={(e) => setNameInput(e.target.value)}
          placeholder="Digite o nome"
          className="w-full p-2 mb-2 text-black"
        />
        <input
          type="text"
          value={docInput}
          onChange={(e) => setDocInput(e.target.value)}
          placeholder="Digite o documento"
          className="w-full p-2 mb-2 text-black"
        />
        <button type="submit" className="w-full bg-blue-500 hover:bg-blue-600 py-2 px-4 rounded">
          {editingId ? "Atualizar" : "Adicionar"}
        </button>
      </form>
      <ul>
        {companies.map(c => (
          <li key={c.id} className="flex justify-between items-center mb-2 p-2 bg-gray-800 rounded">
            {c.name}
            <div>
              <Link className="bg-blue-500 hover:bg-blue-600 py-1 px-3 mr-2 rounded" href={`companies/${c.id}`}>
                View
              </Link>
              <button onClick={() => handleEdit(c.id)} className="bg-yellow-500 hover:bg-yellow-600 py-1 px-3 mr-2 rounded">Edit</button>
              <button onClick={() => handleDelete(c.id)} className="bg-red-500 hover:bg-red-600 py-1 px-3 rounded">Delete</button>
            </div>
          </li>
        ))}
      </ul>
    </div>
  );
}
