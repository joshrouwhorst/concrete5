<?
defined('C5_EXECUTE') or die("Access Denied.");
class BlockPermissionResponse extends PermissionResponse {
	
	// legacy support
	public function canRead() { return $this->validate('view_block'); }
	public function canWrite() { return $this->validate('edit_block'); }
	public function canDeleteBlock() { return $this->validate('delete_block'); }
	public function canAdmin() { return $this->validate('edit_block_permissions'); }
	public function canAdminBlock() { return $this->validate('edit_block_permissions'); }
	
	public function canGuestsViewThisBlock() {
		$pk = PermissionKey::getByHandle('view_block');
		$pk->setPermissionObject($this->getPermissionObject());
		$gg = GroupPermissionAccessEntity::getOrCreate(Group::getByID(GUEST_GROUP_ID));
		$accessEntities = array($gg);
		$valid = false;
		$list = $pk->getAssignmentList(PermissionKey::ACCESS_TYPE_ALL, $accessEntities);
		foreach($list as $l) {
			if ($l->getAccessType() == PermissionKey::ACCESS_TYPE_INCLUDE) {
				$valid = true;
			}
			if ($l->getAccessType() == PermissionKey::ACCESS_TYPE_EXCLUDE) {
				$valid = false;
			}
		}
		
		return $valid;		
	}
}