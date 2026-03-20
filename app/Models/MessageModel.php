<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['sender_id', 'receiver_id', 'message', 'status', 'read_at'];
    protected $useTimestamps = false;

    /**
     * Obtiene la conversación entre dos usuarios
     */
    public function getConversation(int $user1, int $user2, int $limit = 50): array
    {
        return $this->db->table('messages m')
            ->select('
                m.*,
                sender_data.nombre as sender_nombre,
                sender_data.apellido_paterno as sender_apellido,
                receiver_data.nombre as receiver_nombre,
                receiver_data.apellido_paterno as receiver_apellido
            ')
            ->join('users sender_u', 'sender_u.pk_user = m.sender_id')
            ->join('persons sender_data', 'sender_data.pk_phone = sender_u.fk_phone')
            ->join('users receiver_u', 'receiver_u.pk_user = m.receiver_id')
            ->join('persons receiver_data', 'receiver_data.pk_phone = receiver_u.fk_phone')
            ->groupStart()
            ->where('m.sender_id', $user1)
            ->where('m.receiver_id', $user2)
            ->groupEnd()
            ->orGroupStart()
            ->where('m.sender_id', $user2)
            ->where('m.receiver_id', $user1)
            ->groupEnd()
            ->orderBy('m.sent_at', 'ASC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene mensajes enviados por un usuario
     */
    public function getSentMessages(int $userId): array
    {
        return $this->db->table('messages m')
            ->select('
                m.*,
                p.nombre as receiver_nombre,
                p.apellido_paterno as receiver_apellido
            ')
            ->join('users u', 'u.pk_user = m.receiver_id')
            ->join('persons p', 'p.pk_phone = u.fk_phone')
            ->where('m.sender_id', $userId)
            ->orderBy('m.sent_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene mensajes recibidos por un usuario
     */
    public function getReceivedMessages(int $userId): array
    {
        return $this->db->table('messages m')
            ->select('
                m.*,
                p.nombre as sender_nombre,
                p.apellido_paterno as sender_apellido
            ')
            ->join('users u', 'u.pk_user = m.sender_id')
            ->join('persons p', 'p.pk_phone = u.fk_phone')
            ->where('m.receiver_id', $userId)
            ->orderBy('m.sent_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Cuenta mensajes no leídos
     */
    public function countUnread(int $userId): int
    {
        return $this->where('receiver_id', $userId)
            ->where('status', 'sent')
            ->countAllResults();
    }

    /**
     * Marca mensaje como leído
     */
    public function markAsRead(int $messageId): bool
    {
        return $this->update($messageId, [
            'status' => 'read',
            'read_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Marca todos los mensajes de un usuario como leídos
     */
    public function markAllAsRead(int $userId): bool
    {
        return $this->where('receiver_id', $userId)
            ->where('status !=', 'read')
            ->set([
                'status' => 'read',
                'read_at' => date('Y-m-d H:i:s')
            ])
            ->update();
    }

    /**
     * Envía un mensaje
     */
    public function sendMessage(int $senderId, int $receiverId, string $message): int
    {
        return $this->insert([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $message,
            'status' => 'sent'
        ]);
    }

    /**
     * Obtiene mensajes para DataTables (inbox)
     */
    public function getInboxDataTable(int $userId, array $params = []): array
    {
        $builder = $this->db->table('messages m')
            ->select('
                m.id,
                m.message,
                m.sent_at,
                m.status,
                sender_u.pk_user as sender_id,
                p.nombre as sender_nombre,
                p.apellido_paterno as sender_apellido
            ')
            ->join('users sender_u', 'sender_u.pk_user = m.sender_id')
            ->join('persons p', 'p.pk_phone = sender_u.fk_phone')
            ->where('m.receiver_id', $userId);

        $total = $builder->countAllResults(false);

        // Búsqueda
        if (!empty($params['search'])) {
            $search = $params['search'];
            $builder->groupStart()
                ->like('p.nombre', $search)
                ->orLike('p.apellido_paterno', $search)
                ->orLike('m.message', $search)
                ->groupEnd();
        }

        $filtered = $builder->countAllResults(false);

        // Ordenamiento
        $builder->orderBy('m.sent_at', 'DESC');

        // Paginación
        if (!empty($params['start']) && !empty($params['length'])) {
            $builder->limit($params['length'], $params['start']);
        }

        $data = $builder->get()->getResultArray();

        return [
            'data' => $data,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered
        ];
    }
}