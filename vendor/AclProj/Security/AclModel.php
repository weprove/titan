<?php
namespace App\Model;

class AclModel extends Base {

    const ACL_TABLE = 'users_acl';
    const PRIVILEGES_TABLE = 'users_privileges';
    const RESOURCES_TABLE = 'users_resources';
    const ROLES_TABLE = 'roles';

    public function getRoles() {
        return $this->db->query('SELECT r1.roleName, r2.roleName as parent_name
                               FROM '. self::ROLES_TABLE . ' r1
                               LEFT JOIN '. self::ROLES_TABLE . ' r2 ON (r1.parent_id = r2.role_id)
                              ')->fetchAll();
    }

    public function getResources() {
          return $this->db->query('SELECT resourceName FROM '. self::RESOURCES_TABLE . ' ')->fetchAll();
    }

    public function getRules() {
        return $this->db->query('
            SELECT
                a.allowed as allowed,
                ro.roleName as role,
                re.resourceName as resource,
                p.privilegeName as privilege
                FROM ' . self::ACL_TABLE . ' a
                JOIN ' . self::ROLES_TABLE . ' ro ON (a.role_id = ro.role_id)
                LEFT JOIN ' . self::RESOURCES_TABLE . ' re ON (a.resource_id = re.user_resource_id)
                LEFT JOIN ' . self::PRIVILEGES_TABLE . ' p ON (a.privilege_id = p.user_privilege_id)
                ORDER BY a.user_acl_id ASC
        ')->fetchAll();
    }
}