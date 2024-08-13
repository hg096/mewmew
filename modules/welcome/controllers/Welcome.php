<?php

class Welcome extends Trongate
{

    /**
     * Renders the (default) homepage for public access.
     *
     * @return void
     */
    public function index(): void
    {
        // *** 페이지 루트일때 필수, 그리고 index 인데 모듈명이 다르면 그럴때도 명시
        $data['view_module'] = 'welcome';
        // *** 바라보는 view 파일 명이 메서드 명과 다를 때는 필수
        // $data['view_file'] = 'welcome';

        $data["ddd"] =  "ddd";

        $data1["name"] =  "1. 기본으로 설정되는 이름";
        $data1["message"] =  "1. 기본으로 설정되는 문구";

        $data2["name"] =  "2. 기본으로 설정되는 이름";
        $data2["message"] =  "2. 기본으로 설정되는 문구";

        // ob_start();
        // load('uis/sam', $data1);
        // $data['content1'] = ob_get_clean();

        // ob_start();
        // load('uis/sam', $data2);
        // $data['content2'] = ob_get_clean();


        $data['data1'] = $data1;
        $data['data2'] = $data2;

        $this->template('public', $data);

        $sql = "SELECT
        e.name AS employee_name, e.position, d.name AS department_name
        FROM employee e
        JOIN department_id = d.id ";
        // $rows = $this->model->query($sql, 'object');




        // *** (필수) templates/views/public.php 를 바라봄

    }

    function greeting(): void
    {
        $data["name"] = "jone";
        $data["t_alert"] = "<p>This is <strong>bold</strong> text with a script <script>alert('XSS');</script></p>";
        // <script> 태그와 그 내용 제거
        $data["t_alert"] = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $data["t_alert"]);
        // HTML 태그 제거
        $data["t_alert"] = (string)strip_tags($data["t_alert"]);
        //        $data['view_module'] = 'welcome';
        //        $data = out($data);




        $data["view_file"] = "greeting";
        $this->template('is_admin', $data);

        // https://trongate.io/docs/views/returning-view-output-as-a-variable.html 이내용인데 모르겠음
        //        $output = $this->view("greeting", $data, true);
        //        return $output;

        // *** 이렇게는 views 파일의 greeting.php 단독만 리턴할때 이렇게 사용
        //        $this->view("greeting", $data);
    }

    function _init_picture_settings()
    {
        $picture_settings['max_file_size'] = 2000;
        $picture_settings['max_width'] = 1200;
        $picture_settings['max_height'] = 1200;
        $picture_settings['resized_max_width'] = 450;
        $picture_settings['resized_max_height'] = 450;
        $picture_settings['destination'] = 'welcome_pics';
        $picture_settings['target_column_name'] = 'picture';
        $picture_settings['thumbnail_dir'] = 'welcome_pics_thumbnails';
        $picture_settings['thumbnail_max_width'] = 120;
        $picture_settings['thumbnail_max_height'] = 120;
        $picture_settings['upload_to_module'] = true;
        $picture_settings['make_rand_name'] = false;

        return $picture_settings;
    }

    function _make_sure_got_destination_folders($update_id, $picture_settings)
    {

        $destination = $picture_settings['destination'];

        if ($picture_settings['upload_to_module'] == true) {
            $target_dir = APPPATH . 'modules/' . segment(1) . '/assets/' . $destination . '/' . $update_id;
        } else {
            $target_dir = APPPATH . 'public/' . $destination . '/' . $update_id;
        }

        if (!file_exists($target_dir)) {
            //generate the image folder
            mkdir($target_dir, 0777, true);
        }

        //attempt to create thumbnail directory
        if (strlen($picture_settings['thumbnail_dir']) > 0) {
            $ditch = $destination . '/' . $update_id;
            $replace = $picture_settings['thumbnail_dir'] . '/' . $update_id;
            $thumbnail_dir = str_replace($ditch, $replace, $target_dir);
            if (!file_exists($thumbnail_dir)) {
                //generate the image folder
                mkdir($thumbnail_dir, 0777, true);
            }
        }
    }

    function submit_upload_picture($update_id)
    {

        $this->module('trongate_security');
        $this->trongate_security->_make_sure_allowed();

        if ($_FILES['picture']['name'] == '') {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $picture_settings = $this->_init_picture_settings();
        extract($picture_settings);

        $validation_str = 'allowed_types[gif,jpg,jpeg,png]|max_size[' . $max_file_size . ']|max_width[' . $max_width . ']|max_height[' . $max_height . ']';
        $this->validation_helper->set_rules('picture', 'item picture', $validation_str);

        $result = $this->validation_helper->run();

        if ($result == true) {

            $config['destination'] = $destination . '/' . $update_id;
            $config['max_width'] = $resized_max_width;
            $config['max_height'] = $resized_max_height;

            if ($thumbnail_dir !== '') {
                $config['thumbnail_dir'] = $thumbnail_dir . '/' . $update_id;
                $config['thumbnail_max_width'] = $thumbnail_max_width;
                $config['thumbnail_max_height'] = $thumbnail_max_height;
            }

            //upload the picture
            $config['upload_to_module'] = (!isset($picture_settings['upload_to_module']) ? false : $picture_settings['upload_to_module']);
            $config['make_rand_name'] = $picture_settings['make_rand_name'] ?? false;

            $file_info = $this->upload_picture($config);

            //update the database with the name of the uploaded file
            $data[$target_column_name] = $file_info['file_name'];
            $this->model->update($update_id, $data);

            $flash_msg = 'The picture was successfully uploaded';
            set_flashdata($flash_msg);
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    function ditch_picture($update_id)
    {

        if (!is_numeric($update_id)) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->module('trongate_security');
        $this->trongate_security->_make_sure_allowed();

        $result = $this->model->get_where($update_id);

        if ($result == false) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $picture_settings = $this->_init_picture_settings();
        $target_column_name = $picture_settings['target_column_name'];
        $picture_name = $result->$target_column_name;

        if ($picture_settings['upload_to_module'] == true) {
            $picture_path = APPPATH . 'modules/' . segment(1) . '/assets/' . $picture_settings['destination'] . '/' . $update_id . '/' . $picture_name;
        } else {
            $picture_path = APPPATH . 'public/' . $picture_settings['destination'] . '/' . $update_id . '/' . $picture_name;
        }

        $picture_path = str_replace('\\', '/', $picture_path);

        if (file_exists($picture_path)) {
            unlink($picture_path);
        }

        if (isset($picture_settings['thumbnail_dir'])) {
            $ditch = $picture_settings['destination'] . '/' . $update_id;
            $replace = $picture_settings['thumbnail_dir'] . '/' . $update_id;
            $thumbnail_path = str_replace($ditch, $replace, $picture_path);

            if (file_exists($thumbnail_path)) {
                unlink($thumbnail_path);
            }
        }

        $data[$target_column_name] = '';
        $this->model->update($update_id, $data);

        $flash_msg = 'The picture was successfully deleted';
        set_flashdata($flash_msg);
        redirect($_SERVER['HTTP_REFERER']);
    }
}
