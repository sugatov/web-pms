<?php
class RoutesController extends Controller
{
    public function getURL($name)
    {
        $params = array();
        $input = $this->getRawInput();
        if ( ! empty($input)) {
            $params = $this->serializer()->unserialize($input);
        }
        $url = $this->router()->urlFor($name, $params);
        $this->jsonResponse($url);
    }
}
