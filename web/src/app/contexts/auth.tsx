'use client';

import { createContext, ReactNode, useState } from 'react'

type Props = {
  children?: ReactNode;
}

type IAuthContext = {
  authenticated: boolean;
  token: string|null;
  setAuthenticated: (newState: boolean) => void
  setToken: (newState: string) => void
}

const initialValue = {
  authenticated: false,
  token: null,
  setAuthenticated: () => {},
  setToken: () => {}
}

const AuthContext = createContext<IAuthContext>(initialValue)

const AuthProvider = ({children}: Props) => {
  const [ authenticated, setAuthenticated ] = useState(initialValue.authenticated)
  const [ token, setToken ] = useState('')

  return (
    <AuthContext.Provider value={{authenticated, setAuthenticated, token, setToken}}>
      {children}
    </AuthContext.Provider>
  )
}

export {  AuthContext, AuthProvider }