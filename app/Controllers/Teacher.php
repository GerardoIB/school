<?php
    namespace App\Controllers;
    use App\Models\TeacherStudentModel;
    use App\Models\Users;

    class Teacher extends BaseController {
        function index() {
            $session = session();
            $model = new Users();
            $data['user'] = $model->getDataPerson($session->get('pk_user'));
        
      
            $data['usuarios'] = $model->db->table('users')
                                      ->join('persons', 'persons.pk_phone = users.fk_phone')
                                      ->get()->getResultArray();

            
            return view('teacher/dashboard',$data);
        }
        public function getAllStudents(){
            $session = session();
            $idTeacher = session() -> get('pk_user');
            $teacherModel = new TeacherStudentModel();
            try {
                $students = $teacherModel -> getStudentsByTeacher($idTeacher);
                return $this -> response -> setJSON(['students' => $students,'status' => 200]);
            } catch (\Throwable $th) {
                //throw $th;
                return $this -> response -> setJSON(['message' => 'Algo ha salido mal','status' => 500]);
            }



        }
        public function create()
    {
        $data = $this->request->getPost();

        // 1. Validar la petición
        $rules = [
            'pk_phone'         => 'required|exact_length[10]|is_unique[persons.pk_phone]',
            'nombre'           => 'required|max_length[16]',
            'apellido_paterno' => 'required|max_length[16]',
            'apellido_materno' => 'required|max_length[16]',
            'gender'           => 'required|in_list[hombre,mujer]',
            'birthdate'        => 'required|valid_date',
            'password'         => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Errores de validación',
                'errors'  => $this->validator->getErrors()
            ])->setStatusCode(400);
        }

        // 2. Preparar los datos
        $personData = [
            'pk_phone'         => $data['pk_phone'],
            'nombre'           => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'],
            'gender'           => $data['gender'],
            'birthdate'        => $data['birthdate'],
            'telegram_chat_id' => $data['telegram_chat_id'] ?? null
        ];

        $userData = [
            'fk_phone' => $data['pk_phone'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'fk_level' => self::ROLE_TEACHER,
            'locked'   => 0
        ];

        // 3. Pasar la responsabilidad al Modelo
        $userModel = new UserModel();
        
        if ($userModel->createUserWithPerson($personData, $userData)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Profesor creado exitosamente.']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Error de base de datos al guardar el profesor.'])->setStatusCode(500);
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $teacher = $userModel->find($id);

        if (!$teacher) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Profesor no encontrado.'])->setStatusCode(404);
        }

        // Delegar la eliminación al Modelo
        if ($userModel->deleteUserAndPerson($teacher['fk_phone'])) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Profesor eliminado correctamente.']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Error al eliminar el profesor.'])->setStatusCode(500);
    }
    }