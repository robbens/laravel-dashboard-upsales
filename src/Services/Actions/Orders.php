<?php

namespace Robbens\UpsalesTile\Services\Actions;

trait Orders
{
    /**
     * Get orders.
     *
     * @param array $params
     * @return mixed
     */
    public function orders(array $params = [])
    {
        return $this->get('orders', $params);
    }

    /**
     * Get an order.
     *
     * @param int $id
     * @param array $params
     * @return mixed
     */
    public function order(int $id, array $params = [])
    {
        return $this->get('orders/'.$id, $params);
    }

    /**
     * Create an order.
     *
     * @param array $data
     * @param array $params
     * @return mixed
     */
    public function createOrder(array $data, array $params = [])
    {
        return $this->post('orders', $params, $data);
    }

    /**
     * Update an order.
     *
     * @param int $id
     * @param array $data
     * @param array $params
     * @return mixed
     */
    public function updateOrder(int $id, array $data, array $params = [])
    {
        return $this->put('orders/'.$id, $params, $data);
    }
}
