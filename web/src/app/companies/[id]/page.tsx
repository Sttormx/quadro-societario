'use client';

import { getCompany } from "@/services/companies";
import type { NextPage } from "next";
import { usePathname } from "next/navigation";
import { useEffect, useState } from "react";

type Partners = {
  id: string
  name: string
  document: string
}

const Page: NextPage = () => {
  const path = usePathname();
  const id = path.substring(path.lastIndexOf('/') + 1)

  const [current, setCurrent] = useState<{id: string, name: string, document: string}>();
  const [partners, setPartners] = useState<Array<Partners>>([]);

  const [loaded, setLoaded] = useState(false);

  const load = async () => {
    getCompany(id).
      then((data) => {
        const arr = new Array<Partners>;
        setCurrent({id: data.id, name: data.name, document: data.document})
        for (const key in data.partners) {
          if (Object.prototype.hasOwnProperty.call(data.partners, key)) {
            const element = data.partners[key];
            arr.push(element);
          }
        }

        setPartners(arr);
      }).
      catch((err) => alert('Alguma coisa deu errado. Tente novamente mais tarde.'))
  }

  useEffect(() => {
    if (!loaded) {
      load();
      setLoaded(true);
    }
  }, [loaded])

  return (
    <div className="min-h-screen bg-gray-900 text-white p-10">
      <h1 className="text-3xl mb-4">Quadro Societario de {current?.name}</h1>
      <p>Id: {id} </p>
      <p>Name: {current?.name} </p>
      <p>Document: {current?.document}</p>
      <br></br>
      <ul>
        {partners.map(c => (
          <li key={c.id} className="flex justify-between items-center mb-2 p-2 bg-gray-800 rounded">
            {c.name}
          </li>
        ))}
      </ul>
    </div>
)};

export default Page;