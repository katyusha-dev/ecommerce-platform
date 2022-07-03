import { Product, QueryOptionsType } from '@framework/types'
import http from '@framework/utils/http'
import { API_ENDPOINTS } from '@framework/utils/api-endpoints'
import { useQuery } from 'react-query'

export const fetchNewArrivalProducts = async ({ queryKey }: any) => {
  const [_key, _params] = queryKey
  const { data } = await http.get(`${API_ENDPOINTS.NEW_ARRIVAL_PRODUCTS}?limit=${_params.limit}`)
  return data as Product[]
}

export const useNewArrivalProductsQuery = (options: QueryOptionsType) => {
  return useQuery<Product[], Error>(
    [API_ENDPOINTS.NEW_ARRIVAL_PRODUCTS, options],
    fetchNewArrivalProducts
  )
}
